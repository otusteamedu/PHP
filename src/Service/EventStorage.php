<?php


namespace Service;


use Service\Database\RedisDatabase;

class EventStorage
{
    private RedisDatabase $database;

    public function __construct()
    {
        $this->database = new RedisDatabase();
    }

    public function add(string $key, array $data): int
    {
        return $this->database->getClient()->zadd($key, $data);
    }

    public function find(string $key): ?string
    {
        return $this->database->getClient()->zrevrange($key, 0, 0)[0] ?? null;
    }

    public function clear(): ?string
    {
        return $this->database->getClient()->flushdb() ? 'clear' : null;
    }

}