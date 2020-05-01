<?php
namespace Ozycast\App\Core;

use Redis;

Class CacheRedis implements Cache
{
    public $connect;

    public function connect(): Cache
    {
        $this->connect = new Redis();
        $this->connect->connect($_ENV["REDIS_HOST"], $_ENV["REDIS_PORT"]);
        return $this;
    }

    public function clear(): bool
    {
        $this->connect->flushall();
        return true;
    }
}