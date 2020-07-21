<?php

namespace Classes\Database;

class RedisDb implements Driver
{
    public function getConnection()
    {
        $redis = new \Redis();
        return $redis->connect('otus-redis');
    }
}
