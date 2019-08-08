<?php

namespace hw15;

/**
 * Class Client
 * @package hw15
 *
 * @property \Predis\Client $client
 */
class Client
{

    private $client;

    public function __construct()
    {
        $config = parse_ini_file(APP_DIR . '/config.ini', true);

        $this->client = new \Predis\Client($config);
    }

    /**
     * @throws \Exception
     */
    public function startTransaction()
    {
        try {
            $this->client->multi();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function endTransaction()
    {
        try {
            $this->client->exec();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param string $listName
     * @param Event $event
     * @return mixed
     * @throws \Exception
     */
    public function setEventListItem(string $listName,Event $event)
    {
        try {
            return $this->client->set("{$listName}.{$event->id}", json_encode($event));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @param $param
     * @param $value
     * @return int
     * @throws \Exception
     */
    public function addCondition($id, $param, $value)
    {
        try {
            return $this->client->sadd("event.condition.$param.$value", is_array($id) ? $id : [$id]);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $key
     * @return int
     * @throws \Exception
     */
    public function increment($key)
    {
        try {
            return $this->client->incr($key);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    /**
     * @param array $conditions
     * @return array
     * @throws \Exception
     */
    public function getEventIdsByConditions(array $conditions)
    {
        $sets = [];
        foreach ($conditions as $param => $value) {
            $sets[] = "event.condition.$param.$value";
        }
        try {
            return $this->client->sinter($sets);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $ids
     * @return array
     * @throws \Exception
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
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $pattern
     * @return int
     * @throws \Exception
     */
    public function deleteByKeyPattern($pattern)
    {
        try {
            $keys = $this->client->keys($pattern);
            return $this->delete($keys);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $keys
     * @return int
     * @throws \Exception
     */
    public function delete($keys)
    {
        try {
            return $this->client->del(is_array($keys) ? $keys : [$keys]);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}