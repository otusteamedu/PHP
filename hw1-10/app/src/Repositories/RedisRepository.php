<?php
namespace Src\Repositories;

use Redis;
use Src\DTO\EventDto;
use Src\Messages\Responser;
use Src\Models\Condition;
use Src\Models\Event;
use \Src\Exceptions\DataBaseException;

/**
 * Class RedisRepository
 *
 * @package Src\Repositories
 */
class RedisRepository
{
    public const RedisDbName = 'redis';

    private Redis $redis;

    private const KEY = 'events';
    private const LIST_KEY = 'list';
    private const PRIORITY_KEY = 'priority';
    private const CONDITIONS_KEY = 'conditions';
    private const SEPARATOR = '::';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return bool
     * @throws DataBaseException
     */
    public function save(EventDto $eventDTO): bool
    {
        $this->saveEvent($eventDTO);
        $this->savePriority($eventDTO);
        $this->saveConditions($eventDTO);
        $this->saveEventList($eventDTO);
        $this->saveEventConditions($eventDTO);

        return true;
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return bool
     * @throws DataBaseException
     */
    private function saveEvent(EventDTO $eventDTO): bool
    {
        $key = $this->getEventKey($eventDTO->getUid());
        $event = new Event($eventDTO);

        $result = $this->redis->set($key, $event->toJson());

        if ($result !== true) {
            Responser::responseDataBaseFailed('event does not save');
        }

        return $result;
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return int
     * @throws DataBaseException
     */
    private function savePriority(EventDto $eventDTO): int
    {
        $key = $this->getEventPriorityKey();

        $result = $this->redis->zAdd($key, $eventDTO->getPriority(), $eventDTO->getUid());

        if ($result !== 1) {
            Responser::responseDataBaseFailed('priority does not save');
        }

        return $result;
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return bool
     * @throws DataBaseException
     */
    private function saveConditions(EventDto $eventDTO): bool
    {
        $event = new Event($eventDTO);
        $conditions = $event->getConditionsStrings();
        foreach ($conditions as $condition) {
            $key = $this->getConditionsKey($condition);
            $this->redis->sAdd($key, $eventDTO->getUid());
        }

        $key = $this->getEventKey($eventDTO->getUid());
        $result = $this->redis->set($key, $event->toJson());

        if ($result !== true) {
            Responser::responseDataBaseFailed('conditions does not save');
        }

        return $result;
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return bool
     * @throws DataBaseException
     */
    private function saveEventList(EventDTO $eventDTO): bool
    {
        $key = $this->getEventsListKey();

        $result = $this->redis->sAdd($key, $eventDTO->getUid());

        if ($result !== 1) {
            Responser::responseDataBaseFailed('event list does not save');
        }

        return $result;
    }

    /**
     * @param EventDto $eventDTO
     *
     * @return int
     * @throws DataBaseException
     */
    private function saveEventConditions(EventDTO $eventDTO): int
    {
        $key = $this->getEventConditionsKey($eventDTO->getUid());
        $event = new Event($eventDTO);
        $conditions = $event->getConditionsStrings();

        $result = $this->redis->sAddArray($key, $conditions);

        if (!$result) {
            Responser::responseDataBaseFailed('events conditions does not save');
        }

        return (int)$result;
    }

    /**
     * @return int
     * @throws DataBaseException
     */
    public function deleteAll(): int
    {
        $result = $this->redis->del($this->redis->keys(self::KEY . '*'));
        if (!is_int($result)) {
            Responser::responseDataBaseFailed('deleting was wrong');
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getListEvents(): string
    {
        $key = $this->getEventsListKey();

        $list = $this->redis->sMembers($key);

        $result = [];

        foreach ($list as $id) {
            $result[] = $this->getEventByUid($id);
        }

        return \GuzzleHttp\json_encode($result, true);
    }

    public function search(array $params): ?string
    {
        $matchedEvents = $this->getMatchedEvents($params);

        if (!isset($matchedEvents[0])) {
            return null;
        }

        return $this->getEventByUid($matchedEvents[0]);
    }

    private function getMatchedEvents(array $params): array
    {
        $conditions = $this->prepareConditions($params);

        $matchedEvents = [];
        $events = [];

        foreach ($conditions as $condition) {
            $containingEvents = $this->getEventsByCondition($condition);
            $events = array_merge($events, $containingEvents);
        }
        $events = array_unique($events);

        foreach ($events as $uid) {
            $eventConditions = $this->getEventConditions($uid);

            if (count(array_intersect($eventConditions, $conditions)) === count($eventConditions)) {
                $matchedEvents[] = $uid;
            }
        }

        $eventsPriority = $this->getEventsPriority();

        return array_values(array_intersect($eventsPriority, $matchedEvents));
    }

    /**
     * @return array
     */
    private function getEventsPriority(): array
    {
        $key = $this->getEventPriorityKey();

        return $this->redis->zRevRangeByScore(
            $key,
            '+inf',
            '-inf',
            ['limit' => [0, 1000]]
        );
    }

    private function getEventConditions(string $uid): array
    {
        $key = $this->getEventConditionsKey($uid);

        return $this->redis->sMembers($key);
    }

    /**
     * @param $condition
     *
     * @return array
     */
    private function getEventsByCondition($condition): array
    {
        $key = $this->getConditionsKey($condition);

        return $this->redis->sMembers($key);
    }

    private function prepareConditions(array $params): array
    {
        $conditions = [];

        foreach ($params as $k => $v) {
            $conditions[] = Condition::getConditionString($k, $v);
        }

        return $conditions;
    }

    /**
     * @param string $uid
     *
     * @return bool|string
     */
    private function getEventByUid(string $uid)
    {
        $key = $this->getEventKey($uid);

        return $this->redis->get($key);
    }

    /**
     * @return string
     */
    private function getEventPriorityKey(): string
    {
        return self::KEY . self::SEPARATOR . self::PRIORITY_KEY;
    }

    /**
     * @param string $condition
     *
     * @return string
     */
    private function getConditionsKey(string $condition): string
    {
        return self::KEY . self::SEPARATOR . self::CONDITIONS_KEY . self::SEPARATOR . $condition;
    }

    /**
     * @param string $uid
     *
     * @return string
     */
    private function getEventConditionsKey(string $uid): string
    {
        return self::KEY . self::SEPARATOR . $uid . self::SEPARATOR . self::CONDITIONS_KEY;
    }

    /**
     * @param string $uid
     *
     * @return string
     */
    private function getEventKey(string $uid): string
    {
        return self::KEY . self::SEPARATOR . $uid;
    }

    /**
     * @return string
     */
    private function getEventsListKey(): string
    {
        return self::KEY . self::SEPARATOR . self::LIST_KEY;
    }
}