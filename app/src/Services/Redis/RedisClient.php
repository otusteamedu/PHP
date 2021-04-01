<?php

namespace App\Services\Redis;

use Redis;

class RedisClient
{
    private Redis $client;
    private static ?self $instance = null;

    private function __construct()
    {
        $this->client = new Redis();
        $this->client->connect(env('REDIS_HOST'), env('REDIS_PORT'));
        $this->client->select(env('REDIS_DATABASE'));
    }

    public static function get(): Redis
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance->client;
    }
}