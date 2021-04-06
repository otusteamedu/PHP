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

    private const KEY_SEPARATOR  = ':';
    private const KEY            = 'events';
    private const PRIORITY_KEY   = 'priority';
    private const CONDITIONS_KEY = 'conditions';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function store (EventDTO $eventDTO): bool
    {
        $key = $this->getPriorityKey();

        $added = $this->redis->zAdd($key, $eventDTO->getPriority(), $eventDTO->getId());

        if ($added !== 1) {
            throw new Exception('event store error');
        }

        $event = new Event($eventDTO);

        $key        = $this->getConditionsKey($eventDTO->getId());
        $conditions = $event->getConditionsJson();

        $added = $this->redis->set($key, $conditions);

        if ($added !== true) {
            throw new Exception('conditions store error');
        }

        return true;
    }

    private function getPriorityKey (): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::PRIORITY_KEY;
    }

    private function getConditionsKey (int $id): string
    {
        return self::KEY . self::KEY_SEPARATOR . $id . self::KEY_SEPARATOR . self::CONDITIONS_KEY;
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