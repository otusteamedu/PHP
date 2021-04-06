<?php

namespace App\Storage;

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
    private const PRIORITY_KEY   = 'priority';
    private const CONDITIONS_KEY = 'conditions';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function search (array $params): ?EventDTO
    {
        return null;
    }

    public function store (EventDTO $eventDTO): bool
    {
        $this->storePriority($eventDTO);
        $this->storeConditions($eventDTO);
        $this->storeEvent($eventDTO);
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

    public function getList ()
    {
        return $this->redis->keys(self::KEY . '*');
    }
}