<?php

namespace App\Storage;

use App\Models\DTO\EventDTO;
use App\Models\Event;
use Redis;

class RedisStorage extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected Redis $redis;

    private const KEY_SEPARATOR       = ':';
    private const KEY                 = 'events';
    private const CONDITION_SEPARATOR = '=';
    private const CONDITION_KEY       = 'condition';

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
        foreach ($eventDTO->conditions as $param => $value) {
            $this->addToConditionList($param, $value, $eventDTO->id);
        }

        $this->storeEvent($eventDTO);
    }

    private function addToConditionList($param, $value, int $id)
    {
        $key = $this->getKeyForConditionList($param, $value);

        return intval($this->redis->sAdd($key, $id));
    }

    private function getKeyForConditionList ($param, $value): string
    {
        return self::KEY . self::KEY_SEPARATOR . self::CONDITION_KEY . self::KEY_SEPARATOR . $this->getConditionString($param, $value);
    }

    private function getConditionString($param, $value): string
    {
        return $param . self::CONDITION_SEPARATOR . $value;
    }

    private function storeEvent(EventDTO $eventDTO)
    {
        $key = $this->getKeyForEvent($eventDTO->id);

        $event = Event::toJson($eventDTO);

        $this->redis->set($key, $event);
    }

    private function getKeyForEvent (int $id): string
    {
        return self::KEY . self::KEY_SEPARATOR . $id;
    }

    public function getList ()
    {
        return $this->redis->keys('*');
    }
}