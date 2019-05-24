<?php

namespace Otus;

use Predis;

/**
 * Class Client
 * @package Otus
 */
class Client
{

    /**
     * Predis Client
     * @var Predis\Client
     */
    private $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $config = parse_ini_file(APP_DIR . '/config.ini', true);
        $client = new Predis\Client($config);
        $this->client = $client;
    }

    /**
     * Set EventItem in Redis
     * @param EventItem $eventListItem
     * @return mixed
     */
    public function setEventListItem(EventItem $eventListItem)
    {
        return $this->client->set('eventList.' . $eventListItem->id, json_encode($eventListItem));
    }

    /**
     * Incrementing value
     * @param $key
     * @return int
     */
    public function increment($key)
    {
        return $this->client->incr($key);
    }

    /**
     * Adding condition in redis
     * @param $id
     * @param $param
     * @param $value
     * @return int
     */
    public function addCondition($id, $param, $value)
    {
        return $this->client->sadd("event.condition.$param.$value", is_array($id) ? $id : [$id]);
    }

    /**
     * Get events Ids from redis by their conditions
     * @param $conditions
     * @return array
     */
    public function getEventIdsByConditions($conditions)
    {
        $sets = [];
        foreach ($conditions as $param => $value) {
            $sets[] = "event.condition.$param.$value";
        }
        return $this->client->sinter($sets);
    }

    /**
     * Get list of EventsItems by their ids
     * @param $ids
     * @return array
     */
    public function getEventListsByIds($ids)
    {
        $collection = [];
        foreach ($ids as $id) {
            $eventList = $this->client->get('eventList.' . $id);
            if ($eventList) {
                $collection[] = json_decode($eventList);
            }
        }
        return $collection;
    }

    /**
     * Delete key by pattern
     * @param $pattern
     * @return int
     */
    public function deleteByKeyPattern($pattern)
    {
        $keys = $this->client->keys($pattern);
        return $this->delete($keys);
    }

    /**
     * Delete key
     * @param $keys
     * @return int
     */
    public function delete($keys)
    {
        return $this->client->del(is_array($keys) ? $keys : [$keys]);
    }

    /**
     * Sets redis in multi
     */
    public function startTransaction()
    {
        $this->client->multi();
    }

    /**
     * Execute prepared commands
     */
    public function endTransaction()
    {
        $this->client->exec();
    }
}