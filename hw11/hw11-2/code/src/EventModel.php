<?php


namespace RedisApp;


use Redis;

class EventModel
{
    protected string $name;
    protected int $priority;
    protected array $conditions;

    protected object $redis;

    public function __construct()
    {
        $redisInstance = new Redis();
        $redisInstance->connect('redis', 6379);
        $this->redis = $redisInstance;
    }

    public function setName(string $name): EventModel
    {
        $this->name = $name;
        return $this;
    }

    public function setPriority(int $priority): EventModel
    {
        $this->priority = $priority;
        return $this;
    }

    public function setConditions(array $conditions): EventModel
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function addHashToRedis(): bool
    {
        return $this->redis->hMSet($this->name,
            [
                'name' => $this->name,
                'priority' => $this->priority,
                'conditions' => json_encode($this->conditions)
            ]
        );
    }

    public function flushAll()
    {
        $this->redis->flushAll();
    }

}