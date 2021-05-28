<?php

namespace App\Repositories;

use App\Models\Event;
use App\Exceptions\FailToDeleteRecordFromRedis;
use App\Exceptions\FailToFindSpecifiedRecordInRedis;

class RedisEventRepository extends AbstractRedisRepository
{
    /**
     * @return array
     */
    public function getAll(): array
    {
        $events = [];
        $iterator = null;
        $prefix = Event::getPrefixStatic();
        while (($keys = $this->client->scan($iterator, "{$prefix}*")) !== false) {
            $mediator = $this->client->mget($keys);
            $events = array_merge($events, ($mediator != false) ? $mediator : []);
        }

        return $events;
    }

    /**
     * This method creates data in redis like set "params:{$param1}_{value1}_{param2}_{value2} {eventName}".
     * This must help me searching events by parameters.
     *
     * @param array $conditions
     * @param string $eventName
     *
     * @return bool|int
     */
    public function saveConditionsEventIndex(array $conditions, string $eventName): bool|int
    {
        $keys = [];
        foreach ($conditions as $paramKey => $paramValue) {
            $keys[] = "{$paramKey}-{$paramValue}";
        }

        $keys = implode('_', $keys);

        return $this->client->sAdd("params:{$keys}", $eventName);
    }

    /**
     * @param string $pattern
     *
     * @throws FailToDeleteRecordFromRedis
     */
    public function flushDataByPattern(string $pattern)
    {
        while (($keys = $this->client->scan($iterator, "{$pattern}*")) !== false) {
            foreach ($keys as $key) {
                $result = $this->client->del($key);

                if ($result === 0)
                    throw new FailToDeleteRecordFromRedis();
            }
        }
    }

    /**
     * Redis searches for keys matching "params" pattern while at php side
     * more specific search is performed using search pattern created from request data
     * because redis cannot search by regexp inside redis-cli (:.
     *
     * @param array $searchData
     *
     * @return array
     */
    public function searchEventKeyByParamsInIndex(array $searchData): array
    {
        $mediator = [];
        foreach ($searchData as $key => $value) {
            $mediator[] = sprintf('(%s-%s)?', $key, $value);
        }

        $searchPattern = '/^(params:' . implode('_?', $mediator) . ')$/';

        $result = [];
        while (($keys = $this->client->scan($iterator, "params*")) !== false) {
            foreach ($keys as $key) {
                if (preg_match($searchPattern, $key)) {
                    $result[] = $this->client->sMembers($key);
                }
            }
        }
        return array_unique(array_map('current', $result));
    }

    /**
     * @param string|array $data
     *
     * @return string|array
     *
     * @throws FailToFindSpecifiedRecordInRedis
     */
    public function getEventByKeys(string|array $data): string|array
    {
        $prefix = Event::getPrefixStatic();
        if (is_string($data)) {
            $result = $this->client->get("{$prefix}:{$data}");

            if (!$result) {
                throw new FailToFindSpecifiedRecordInRedis();
            }
        } else if (is_array($data)) {
            $prefixed = array_map(function ($value) use ($prefix) {
                return "{$prefix}:{$value}";
            }, $data);

            $result = $this->client->mget($prefixed);
        }

        return $result;
    }
}
