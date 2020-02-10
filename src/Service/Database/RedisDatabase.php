<?php declare(strict_types=1);

namespace Service\Database;

use Predis\Client;

class RedisDatabase
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => 'redis'
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
