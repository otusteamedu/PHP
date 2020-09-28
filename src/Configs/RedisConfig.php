<?php

namespace Configs;

class RedisConfig
{
    public static array $config = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'timeout' => 0.0,
        'retryInterval' => 15,
        'readTimeout' => 2,
        'persistenceId' => null,
        'database' => 0
    ];
}