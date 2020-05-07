<?php


namespace App\DB;

use Predis\Client;

class RedisDB implements DBInterface
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => 'redis'
        ]);
    }

    /**
     * @param $key
     * @param $data
     * @return int|mixed
     */
    public function save($key, $data)
    {
        return $this->client->hmset($key, $data);
    }

    /**
     * @inheritDoc
     */
    public function find($params)
    {
        $names = $this->client->keys('events:*');

        $foundEvents = [];

        foreach ($names as $name) {
            $data = $this->client->hgetall($name);
            reset($data);

            $data = json_decode($data[0], JSON_OBJECT_AS_ARRAY, 512, JSON_THROW_ON_ERROR);

            $matchedConditions = [];

            foreach ($data['conditions'] as $keyCondition => $condition) {
                foreach ($params as $param) {
                    if ($condition === $param) {
                        $matchedConditions[$keyCondition] = $condition;
                    }

                }
            }
            if ($matchedConditions === $params) {
                $foundEvents[] = $data;
            }
        }
        if(empty($foundEvents)) {
            return null;
        }

        $priority = 0;
        $foundEvents = array_filter($foundEvents, static function ($v) use (&$priority) {
            if($v['priority'] > $priority) {
                $priority = $v['priority'];
                return true;
            }
            return false;
        });
        return end($foundEvents);
    }

    /**
     * @return mixed
     */
    public function deleteAll()
    {
        return $this->client->flushall();
    }
}