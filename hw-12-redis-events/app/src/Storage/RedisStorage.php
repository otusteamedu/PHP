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
    private const EVENTS_KEY             = 'events';
    private const CONDITION_KEY          = 'condition';
    private const FULL_CONDITIONS_KEY    = 'full_conditions';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function deleteAll (): int
    {
        return intval($this->redis->del($this->redis->keys(self::EVENTS_KEY . '*')));
    }

    public function store (EventDTO $eventDTO): bool
    {
        $fullConditions = [];

        foreach ($eventDTO->conditions as $key => $value) {
            $this->addEventToCondition($key, $value, $eventDTO);

            $fullConditions[] = $key . self::CONDITIONS_KV_SEPARATOR . $value;
        }

        //$fullConditions = implode(self::CONDITIONS_SEPARATOR, $fullConditions);

        $this->storeFullContidions($fullConditions, $eventDTO);

        return true;
    }

    private function storeFullContidions(array $fullConditions, EventDTO $eventDTO)
    {
        $key = $this->getFullConditionsKey($eventDTO->id);

        $this->redis->sAddArray($key, $fullConditions);
    }

    private function addEventToCondition (string $key, string $value, EventDTO $eventDTO): int
    {
        $key = $this->getConditionKey($key, $value);

        $result = $this->redis->sAdd($key, 'ddd');

        return intval($result);
    }

    private function getConditionKey(string $key, string $value)
    {
        return self::EVENTS_KEY . self::KEY_SEPARATOR . self::CONDITION_KEY . self::KEY_SEPARATOR . $key . self::CONDITIONS_KV_SEPARATOR . $value;
    }

    private function getFullConditionsKey(int $id): string
    {
        return self::EVENTS_KEY . self::KEY_SEPARATOR . self::FULL_CONDITIONS_KEY . self::KEY_SEPARATOR . $id;
    }

    public function getList ()
    {
        var_dump($this->redis->set('events:ping', 'pong'));

        $keys = $this->redis->keys(self::EVENTS_KEY . '*');

        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $this->redis->get($key);
        }

        return $result;
    }

    /*public function store (EventDTO $eventDTO): bool
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
    }*/

    /*private function getConditionsKey(EventDTO $eventDTO)
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
    }*/
}