<?php

declare(strict_types=1);

namespace App\Model\Event\Repository;

use App\Model\Event\Entity\Condition;
use App\Model\Event\Entity\Event;
use App\Model\Event\Entity\EventId;
use App\Model\Event\Exception\EventNotFoundException;
use Averias\RedisJson\Client\RedisJsonClientInterface;

class RedisEventRepository implements EventRepositoryInterface
{

    private const KEY__EVENT_IDS             = 'event-ids';
    private const KEY__EVENT_IDS_BY_PRIORITY = 'event-ids-by-priority';
    private const PREFIX_KEY__CONDITIONS     = 'conditions:';
    private const PREFIX_KEY__EVENT          = 'event:';
    private RedisJsonClientInterface $redisClient;

    public function __construct(RedisJsonClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    public function getAll(): array
    {
        $eventIds = $this->getAllEventIds();

        $data = $this->getDataEventsByIds($eventIds);

        return array_map(fn($value) => $this->buildEvent($value), $data);
    }

    public function get(int $limit, int $skip): array
    {
        if (!$eventIds = $this->getEventIdsByRange($limit, $skip)) {
            return [];
        }

        if (!$data = $this->getDataEventsByIds($eventIds)) {
            return [];
        }

        return array_map(fn($value) => $this->buildEvent($value), $data);
    }

    private function getEventIdsByRange(int $limit, int $skip): array
    {
        if (!$limit) {
            return [];
        }

        $limit -= 1;

        return $this->redisClient->lRange(self::KEY__EVENT_IDS, $skip, $skip + $limit);
    }

    private function getAllEventIds(): array
    {
        return $this->redisClient->lRange(self::KEY__EVENT_IDS, 0, -1);
    }

    public function getOne(EventId $id): Event
    {
        if (!$data = $this->getDataEventsByIds([$id->getValue()])) {
            throw new EventNotFoundException('Событие не найдено');
        }

        $data = array_shift($data);

        return $this->buildEvent($data);
    }

    private function getDataEventsByIds(array $eventIds): array
    {
        $eventKeys = array_map(fn($eventId) => $this->generateEventKey($eventId), $eventIds);

        return array_filter($this->redisClient->jsonMultiGet($eventKeys));
    }

    private function buildEvent(array $data): Event
    {
        $event = new Event(new EventId($data['id']), $data['name'], $data['priority']);

        foreach ($data['conditions'] as $condition) {
            $condition = new Condition(strval($condition['paramName']), strval($condition['paramValue']));

            $event->addCondition($condition);
        }

        return $event;
    }

    public function add(Event $event): void
    {
        $this->saveAggregate($event);
        $this->savePriority($event->getId(), $event->getPriority());
        $this->saveConditions($event->getId(), $event->getConditions());
    }

    private function saveAggregate(Event $event): void
    {
        $eventId = $event->getId()->getValue();

        $this->redisClient->rPush(self::KEY__EVENT_IDS, $eventId);
        $this->redisClient->jsonSet($this->generateEventKey($eventId), $event->toArray());
    }

    private function savePriority(EventId $eventId, int $priority): void
    {
        $this->redisClient->hSet(self::KEY__EVENT_IDS_BY_PRIORITY, $eventId->getValue(), $priority);
    }

    /**
     * @param Condition[] $conditions
     */
    private function saveConditions(EventId $eventId, array $conditions): void
    {
        $conditionsKey = $this->generateConditionsKey($conditions);

        $this->redisClient->sAdd($conditionsKey, $eventId->getValue());
    }

    public function delete(Event $event): void
    {
        $eventId = $event->getId()->getValue();

        $this->deleteConditions($event->getId(), $event->getConditions());
        $this->redisClient->hDel(self::KEY__EVENT_IDS_BY_PRIORITY, $eventId);
        $this->deleteAggregate($event);
    }

    /**
     * @param Condition[] $conditions
     */
    private function deleteConditions(EventId $eventId, array $conditions): void
    {
        $conditionsKey = $this->generateConditionsKey($conditions);

        $this->redisClient->sRem($conditionsKey, $eventId->getValue());
    }

    private function deleteAggregate(Event $event): void
    {
        $eventId = $event->getId()->getValue();

        $this->redisClient->del($this->generateEventKey($eventId));
        $this->redisClient->lRem(self::KEY__EVENT_IDS, $eventId, 0);
    }

    public function deleteAll(): void
    {
        $this->deleteAllConditions();
        $this->redisClient->del(self::KEY__EVENT_IDS_BY_PRIORITY);
        $this->deleteAllAggregates();
    }

    private function deleteAllConditions(): void
    {
        if (!$conditionsKeys = $this->redisClient->keys(self::PREFIX_KEY__CONDITIONS . '*')) {
            return;
        }

        $this->redisClient->del(...$conditionsKeys);
    }

    private function deleteAllAggregates(): void
    {
        if ($eventIds = $this->getAllEventIds()) {
            $eventKeys = array_map(fn($eventId) => $this->generateEventKey($eventId), $eventIds);
            $this->redisClient->del(...$eventKeys);
        }

        $this->redisClient->del(self::KEY__EVENT_IDS);
    }

    public function findOneByConditions(array $conditions): ?Event
    {
        if (!$eventIds = $this->getEventIdsByConditions($conditions)) {
            return null;
        }

        $eventId = $this->extractEventIdWithMaxPriority($eventIds);

        return $this->getOne(new EventId($eventId));
    }

    /**
     * @param Condition[] $conditions
     *
     * @return array
     */
    private function getEventIdsByConditions(array $conditions): array
    {
        $conditionsKey = $this->generateConditionsKey($conditions);

        return array_unique($this->redisClient->sMembers($conditionsKey));
    }

    private function extractEventIdWithMaxPriority(array $eventIds): string
    {
        $eventsPriorities = $this->getPrioritiesByEventIds($eventIds);

        arsort($eventsPriorities);

        return array_key_first($eventsPriorities);
    }

    private function getPrioritiesByEventIds(array $eventIds): array
    {
        return $this->redisClient->hMGet(self::KEY__EVENT_IDS_BY_PRIORITY, $eventIds);
    }

    /**
     * @param Condition[] $conditions
     *
     * @return string
     */
    private function generateConditionsKey(array $conditions): string
    {
        $conditions = $this->sortConditionsByParamName($conditions);

        return self::PREFIX_KEY__CONDITIONS . $this->convertConditionsToString($conditions);
    }

    /**
     * @param Condition[] $conditions
     *
     * @return array
     */
    private function sortConditionsByParamName(array $conditions): array
    {
        usort($conditions, function ($firstCondition, $secondCondition) {
            return $firstCondition->getParamName() <=> $secondCondition->getParamName();
        });

        return $conditions;
    }

    /**
     * @param Condition[] $conditions
     *
     * @return string
     */
    private function convertConditionsToString(array $conditions): string
    {
        $array = [];

        foreach ($conditions as $condition) {
            $array[] = $condition->getParamName() . ':' . $condition->getParamValue();
        }

        return implode('-', $array);
    }

    private function generateEventKey(string $eventId): string
    {
        return self::PREFIX_KEY__EVENT . $eventId;
    }

}