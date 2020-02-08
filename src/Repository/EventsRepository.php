<?php declare(strict_types=1);

namespace Repository;

use Service\Database\RedisDatabase;

class EventsRepository
{
    private RedisDatabase $database;

    public function __construct()
    {
        $this->database = new RedisDatabase();
    }

    public function save(string $key, array $data): int
    {
        return $this->database->getClient()->zadd($key, $data);
    }

    public function findOne(string $key): ?string
    {
        return $this->database->getClient()->zrevrange($key, 0, 0)[0] ?? null;
    }

    public function delete(string $key, string $member): int
    {
        return $this->database->getClient()->zrem($key, $member);
    }
}
