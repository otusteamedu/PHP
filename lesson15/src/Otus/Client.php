<?php

namespace Otus;

use Exception;
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
        try {
            return $this->client->set('eventList.' . $eventListItem->id, json_encode($eventListItem));
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Incrementing value
     * @param $key
     * @return int
     */
    public function increment($key)
    {
        try {
            return $this->client->incr($key);
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
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
        try {
            return $this->client->sadd("event.condition.$param.$value", is_array($id) ? $id : [$id]);
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Get events Ids from redis by their conditions
     * @param $conditions
     * @return array
     */
    public function getEventIdsByConditions(array $conditions)
    {
        $sets = [];
        foreach ($conditions as $param => $value) {
            $sets[] = "event.condition.$param.$value";
        }
        try {
            return $this->client->sinter($sets);
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Get list of EventsItems by their ids
     * @param $ids
     * @return array
     */
    public function getEventListsByIds($ids)
    {
        $collection = [];
        try {
            foreach ($ids as $id) {
                $eventList = $this->client->get('eventList.' . $id);
                if ($eventList) {
                    $collection[] = json_decode($eventList);
                }
            }
            return $collection;
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Delete key by pattern
     * @param $pattern
     * @return int
     */
    public function deleteByKeyPattern($pattern)
    {
        try {
            $keys = $this->client->keys($pattern);
            return $this->delete($keys);
        } catch (\Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Delete key
     * @param $keys
     * @return int
     */
    public function delete($keys)
    {
        try {
            return $this->client->del(is_array($keys) ? $keys : [$keys]);
        } catch (\Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Sets redis in multi
     */
    public function startTransaction()
    {
        try {
            $this->client->multi();
        } catch (\Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }

    /**
     * Execute prepared commands
     */
    public function endTransaction()
    {
        try {
            $this->client->exec();
        } catch (\Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . PHP_EOL;
        }
    }
}