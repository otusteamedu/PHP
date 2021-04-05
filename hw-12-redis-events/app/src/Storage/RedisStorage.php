<?php

namespace App\Storage;

use App\Models\DTO\EventDTO;
use App\Models\Event;
use Redis;

class RedisStorage extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected Redis $redis;

    private const KEY_SEPARATOR = ':';
    private const KEY           = 'events';
    private const PRIORITY_KEY  = 'priority';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function deleteAll (): int
    {
        return intval($this->redis->del($this->redis->keys(self::KEY . '*')));
    }

    public function store (EventDTO $eventDTO): bool
    {
        $this->storeEvent($eventDTO);

        $this->storePriority($eventDTO->priority, $eventDTO->id);
    }

    private function storeEvent(EventDTO $eventDTO)
    {
        $key = $this->getKeyForEvent($eventDTO->id);

        $event = Event::toJson($eventDTO);

        $this->redis->set($key, $event);
    }

    private function storePriority(int $priority, int $id)
    {
        $key = $this->getKeyForPriority();

        $this->redis->zAdd($key, [], $priority, $id);
    }

    private function getKeyForEvent (int $id): string
    {
        return self::KEY . self::KEY_SEPARATOR . $id;
    }

    private function getKeyForPriority (): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::PRIORITY_KEY;
    }

    public function getList ()
    {
        return $this->redis->keys('*');
    }
}