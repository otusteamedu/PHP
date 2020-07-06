<?php


namespace App\Database\Drivers;


class Redis implements Driver
{
    public function getConnection($params = null)
    {
        $redisClient = new \Redis();
        return $redisClient->connect('redis');
    }
}