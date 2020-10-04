<?php

namespace Otus;

use Redis;

class RedisClientFactory
{
    public static function make(): Redis
    {
        $config = new Config('redis');

        $client = new Redis();
        $client->connect($config->get('host'), $config->get('port'));

        return $client;
    }
}
