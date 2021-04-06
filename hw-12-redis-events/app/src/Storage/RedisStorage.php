<?php

namespace App\Storage;

use App\Log\Log;
use App\Models\Condition;
use App\Models\DTO\EventDTO;
use App\Models\Event;
use Exception;
use Redis;

class RedisStorage extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected Redis $redis;

    private const KEY_SEPARATOR  = '::';
    private const KEY            = 'events';
    private const LIST_KEY       = 'list';
    private const PRIORITY_KEY   = 'priority';
    private const CONDITIONS_KEY = 'conditions';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function search (array $params): ?string
    {
        $matchedEvents = $this->getMatchedEvents($params);

        if (!isset($matchedEvents[0])) {
            return null;
        }

        $event = $this->getEventById($matchedEvents[0]);

        return $event;
    }

    private function getEventById (int $id)
    {
        $key = $this->getEventKey($id);

        return $this->redis->get($key);
    }

    private function getMatchedEvents (array $params): array
    {
        $conditions = $this->prepareConditions($params);

        $matchedEvents = [];
        $events        = [];

        foreach ($conditions as $condition) {
            $containingEvents = $this->getEventsByCondition($condition);

            $events = array_merge($events, $containingEvents);
        }

        $events = array_unique($events);

        foreach ($events as $id) {
            $eventConditions = $this->getEventConditions($id);

            if (count(array_intersect($eventConditions, $conditions)) === count($eventConditions)) {
                $matchedEvents[] = $id;
            }
        }

        $eventsPriority = $this->getEventsPriority();

        return array_values(array_intersect($eventsPriority, $matchedEvents));
    }

    private function getEventsPriority()
    {
        $key = $this->getPriorityKey();

        return $this->redis->zRevRangeByScore(
            $key,
            '+inf',
            '-inf',
            ['limit' => [0, 1000]]
        );
    }

    private function getEventConditions (int $id): array
    {
        $key = $this->getEventConditionsKey($id);

        return (array)$this->redis->sMembers($key);
    }

    private function getEventsByCondition ($condition): array
    {
        $key = $this->getConditionsKey($condition);

        return (array)$this->redis->sMembers($key);
    }

    private function prepareConditions (array $params): array
    {
        $conditions = [];

        foreach ($params as $k => $v) {
            $conditions[] = Condition::getConditionString($k, $v);
        }

        return $conditions;
    }

    public function store (EventDTO $eventDTO): bool
    {
        $this->storePriority($eventDTO);
        $this->storeConditions($eventDTO);
        $this->storeEvent($eventDTO);
        $this->storeEventList($eventDTO);
        $this->storeEventConditions($eventDTO);

        return true;
    }

    private function storePriority (EventDTO $eventDTO): int
    {
        $key = $this->getPriorityKey();

        $added = $this->redis->zAdd($key, $eventDTO->getPriority(), $eventDTO->getId());

        if ($added !== 1) {
            throw new Exception('event store error');
        }

        return $added;
    }

    private function storeConditions (EventDTO $eventDTO): bool
    {
        $event      = new Event($eventDTO);
        $conditions = $event->getConditionsStrings();

        foreach ($conditions as $condition) {
            $key = $this->getConditionsKey($condition);

            $this->redis->sAdd($key, $eventDTO->getId());
        }

        $key = $this->getEventKey($eventDTO->getId());

        $added = $this->redis->set($key, $event->toJson());

        if ($added !== true) {
            throw new Exception('event store error');
        }

        return $added;
    }

    private function storeEvent (EventDTO $eventDTO): bool
    {
        $key   = $this->getEventKey($eventDTO->getId());
        $event = new Event($eventDTO);

        $added = $this->redis->set($key, $event->toJson());

        if ($added !== true) {
            throw new Exception('event store error');
        }

        return $added;
    }

    private function storeEventList (EventDTO $eventDTO): bool
    {
        $key = $this->getEventsListKey();

        $added = $this->redis->sAdd($key, $eventDTO->getId());

        if ($added !== true) {
            throw new Exception('events list store error');
        }

        return $added;
    }

    private function storeEventConditions (EventDTO $eventDTO): bool
    {
        $key        = $this->getEventConditionsKey($eventDTO->getId());
        $event      = new Event($eventDTO);
        $conditions = $event->getConditionsStrings();

        $added = $this->redis->sAddArray($key, $conditions);

        if ($added !== true) {
            throw new Exception('event store error');
        }

        return $added;
    }

    private function getPriorityKey (): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::PRIORITY_KEY;
    }

    private function getConditionsKey (string $condition): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::CONDITIONS_KEY . self::KEY_SEPARATOR . $condition;
    }

    private function getEventConditionsKey (int $id): string
    {
        return self::KEY . self::KEY_SEPARATOR . $id . self::KEY_SEPARATOR . self::CONDITIONS_KEY;
    }

    private function getEventKey (int $id): string
    {
        return self::KEY . self::KEY_SEPARATOR . $id;
    }

    public function deleteAll (): int
    {
        return intval($this->redis->del($this->redis->keys(self::KEY . '*')));
    }

    public function getList (): array
    {
        $key = $this->getEventsListKey();

        $list = $this->redis->sMembers($key);

        $result = [];

        foreach ($list as $id) {
            $result[] = json_decode($this->getEventById($id), true);
        }

        return $result;
    }

    private function getEventsListKey (): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::LIST_KEY;
    }
}