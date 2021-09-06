<?php

namespace App\Repository\Redis;

use Redis;

class RedisReadRepository
{
    /**
     * Коннектор для сервера Redis
     * @var Redis
     */
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function getInfo():array
    {
        return $this->redis->info();
    }
}