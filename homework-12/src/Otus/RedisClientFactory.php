<?php

namespace Otus;

use Otus\Config\ConfigFactory;
use Redis;

class RedisClientFactory
{
    public static function make(): Redis
    {
        $config = ConfigFactory::make();

        $client = new Redis();
        $client->connect($config->get('redis_host'), $config->get('redis_port'));

        return $client;
    }
}
