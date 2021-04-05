<?php

namespace App\Storage;

use App\Models\DTO\EventDTO;
use Redis;

class RedisStorage extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected Redis $redis;

    private const KEY_SEPARATOR           = ':';
    private const CONDITIONS_SEPARATOR    = '--';
    private const CONDITIONS_KV_SEPARATOR = '=';
    private const STORAGE_KEY             = 'events';
    private const CONDITIONS_KEY          = 'conditions';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function deleteAll (): int
    {
        return intval($this->redis->del($this->redis->keys(self::STORAGE_KEY . '*')));
    }

    public function store (EventDTO $eventDTO): bool
    {
        $key = $this->getConditionsKey($eventDTO);

        $result = $this->redis->zAdd($key, [], $eventDTO->priority, $eventDTO->id);

        if ($result !== 1) {
            return false;
        }

        $key = $this->getEventKey($eventDTO);

        $result = $this->redis->set($key, $eventDTO->event);

        if ($result !== true) {
            return false;
        }

        return true;
    }

    private function getConditionsKey(EventDTO $eventDTO)
    {
        $conditions = $this->getConditionsSting($eventDTO->conditions);

        return self::STORAGE_KEY . self::KEY_SEPARATOR . self::CONDITIONS_KEY . self::KEY_SEPARATOR . $conditions;
    }

    private function getConditionsSting(array $conditions): string
    {
        $conditions = $this->getSortedConditions($conditions);

        $result = [];

        foreach ($conditions as $param => $value) {
            $result[] = $param . self::CONDITIONS_KV_SEPARATOR . $value;
        }

        return implode(self::CONDITIONS_SEPARATOR, $result);
    }

    private function getSortedConditions(array $conditions): array
    {
        ksort($conditions);

        return $conditions;
    }

    private function getEventKey(EventDTO $eventDTO)
    {
        return self::STORAGE_KEY . self::KEY_SEPARATOR . $eventDTO->id;
    }
}