<?php


namespace App\Services\Events\Repositories;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;

class RedisCacheEventRepository implements Interfaces\CacheEventRepositoryInterface
{
    private $client;

    public function __construct(Connection $connection)
    {
        $this->client = $connection->client();
    }

    public function store(string $key, string $priority, string $event): int
    {
        return $this->client->zAdd($key, $priority, $event);
    }

    public function getOne(string $key): ?string
    {
        $result = $this->client->zRevRange($key, 0, 0);
        return (!empty($result)) ? $result[0] : null;
    }

    public function flush(): bool
    {
        return $this->client->flushAll();
    }
}
