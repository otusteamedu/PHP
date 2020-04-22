<?php


namespace Service\Database;

use Predis\Client;

class RedisDatabase
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['host' => '127.0.0.1']);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}