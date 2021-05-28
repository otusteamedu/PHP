<?php

namespace App\Clients;

use Redis;
use App\Exceptions\FailToConnectToRedis;
use App\Exceptions\FailToAuthorizeToRedis;

class RedisClient extends Redis
{
    /**
     * RedisClient constructor.
     *
     * @throws FailToAuthorizeToRedis
     * @throws FailToConnectToRedis
     */
    public function __construct()
    {
        parent::__construct();
        $this->connectToStorage();
    }

    /**
     * @throws FailToAuthorizeToRedis
     * @throws FailToConnectToRedis
     */
    private function connectToStorage()
    {
        if (!$this->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']))
            throw new FailToConnectToRedis();

        if (!$this->auth($_ENV['REDIS_PASSWORD']))
            throw new FailToAuthorizeToRedis();
    }
}
