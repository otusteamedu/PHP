<?php

namespace Otushw\Storage;

use Otushw\EventDTO;
use Otushw\UserRequestDTO;
use \Redis;
use Otushw\UserException;
use Otushw\AppException;

/**
 * Redis has struct
 *
 * events:priority - this is sorted set, which store priority and string "event:ID".
 *   Keeps the priorities for all events. This is key like index in RDBS.
 *
 * events:ID:conditions - this is set, which store conditions by given event ID.
 * events:ID:event - this is string, which store event as string by given event ID.
 *
 * Redis has helpers sets.
 * For each element from the event condition, a separate set is created
 * with the value set name.
 *
 * Example:
 * priority: 1000,
 * conditions: {
 *   param1 = 1,
 *   param2 = 2
 * },
 * event: {
 *   event_1
 * }
 * it will have ID 1610914718 (current timestamp)
 * Redis will have struct for this event like this:
 *   events:priority has "events:1610914718"
 *   events:1610914718:conditions has 2 items: "param1 = 1" and "param2 = 2"
 *   events:1610914718:event has string "event_1"
 *   events:param1=1 has string "events:1610914718:conditions" (other sets
 *     that have the same parameter will be here)
 *   events:param2=2 has string "events:1610914718:conditions" (other sets
 *     that have the same parameter will be here)
 *
 */


/**
 * Class RedisDAO
 *
 * @package Otushw\Storage
 *
 */
class RedisDAO implements StorageInterface
{

    const STORAGE_NAME = 'Redis';
    const KEY = 'events';

    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    public function find(UserRequestDTO $userRequest): ?EventDTO
    {
        $sets = [];
        $sets = $this->findEvents($userRequest->conditions);
        $eventIDs = $this->findSuitableEvents($userRequest->conditions, $sets);

        $raw = $this->getEventMaxPriority($eventIDs);
        $rrr = $this->generateKeyEvent($raw['event_id']);
        $eventData = $this->redis->get($this->generateKeyEvent($raw['event_id']));
        $conditions = $this->redis->sMembers($this->generateKeyConditions($raw['event_id']));
        return new EventDTO($raw['event_id'], $raw['priority'], $conditions, $eventData);
    }

    public function set(EventDTO $event): bool
    {
        $key = $this->generateKey($event->id);
        $part_one = $this->redis->multi()
            ->zAdd($this->generatePriority(), [], $event->priority, $key)
            ->set($this->generateKeyEvent($event->id), $event->event)
            ->exec();
        $this->redis->multi();
        foreach ($event->conditions as $condition) {
            $this->redis->sAdd($this->generateKeyConditions($event->id), $condition);
            $this->redis->sAdd($this->generateHelperConditions($condition), $key . ':conditions');
        }
        $part_two = $this->redis->exec();
        $result = array_merge($part_one, $part_two);
        return $this->checkCommandExecution($result);
    }

    public function delete(): bool
    {
        $result = $this->redis->del($this->redis->keys(self::KEY . '*'));
        return !empty($result);
    }

    private function getEventMaxPriority(array $eventIDs): array
    {
        $scores = array_column($eventIDs, 'priority');
        $maxPriority = max($scores);
        foreach ($eventIDs as $item) {
            if ($item['priority'] == $maxPriority) {
                $eventID = $item['event_id'];
                break;
            }
        }

        return ['priority' => $maxPriority, 'event_id' => $eventID];
    }

    /**
     * @param array $conditions
     * @param array $sets
     *
     * @return array
     */
    private function findSuitableEvents(array $conditions, array $sets): array
    {
        foreach ($sets as $keyConditions => &$item) {
            foreach ($conditions as $condition) {
                $result = $this->redis->sIsMember($keyConditions, $condition);
                if ($result) {
                    $item['suitable_number']++;
                }
            }
        }
        unset($item);
        $buf = [];
        $eventIDs = [];
        foreach ($sets as $keyConditions => $item)  {
            if ($item['number'] == $item['suitable_number']) {
                $eventID = $this->getEventIDFromKeyConditions($keyConditions);
                $key = $this->generateKey($eventID);
                $eventIDs[$key] = [
                    'priority' => $this->redis->zScore($this->generatePriority(), $key),
                    'event_id' => $eventID
                ];
            }
        }

        return $eventIDs;
    }

    /**
     * @param array $conditions
     *
     * @return array
     * @throws Exception
     */
    private function findEvents(array $conditions): array
    {
        $sets = [];
        foreach ($conditions as $item) {
            $item = $this->generateHelperConditions($item);
            $buf = $this->redis->sMembers($item);
            foreach ($buf as $keyConditions) {
                $sets[$keyConditions] = [
                    'number' => $this->redis->sCard($keyConditions),
                    'suitable_number' => 0
                ];
            }
        }

        if (empty($sets)) {
            throw new AppException('No sets found');
        }

        return $sets;
    }

    /**
     * @param string $keyConditions
     *
     * @return string
     * @throws Exception
     */
    private function getEventIDFromKeyConditions(string $keyConditions): string
    {
        $result = explode(':', $keyConditions);
        if (empty($result[1])) {
            throw new AppException('Redis is not structured correctly.');
        }
        return $result[1];
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function generateKey(string $id): string
    {
        return self::KEY . ':' . $id;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function generateKeyConditions(string $id): string
    {
        return $this->generateKey($id) . ':conditions';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function generateKeyEvent(string $id): string
    {
        return $this->generateKey($id) . ':event';
    }

    /**
     * @param string $item
     *
     * @return string
     */
    private function generateHelperConditions(string $item): string
    {
        return self::KEY . ':' . $item;
    }

    /**
     * @param bool $helper
     *
     * @return string
     */
    private function generatePriority(bool $helper = false): string
    {
        $sufix = '';
        if ($helper) {
            $sufix = ':helper';
        }
        return self::KEY . ':priority' . $sufix;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    private function checkCommandExecution(array $data): bool
    {
        $result = true;
        foreach ($data as $item) {
            if (empty($item)) {
                $item = false;
            } else {
                $item = true;
            }
            $result = $result && $item;
        }
        return $result;
    }

}