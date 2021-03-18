<?php


namespace Repetitor202\Application\Clients\KeyValueStorages\Connections;


use Redis;

class RedisConnection
{
    protected static ?Redis $client = null;

    final private function __construct(){}
    final private function __clone(){}
    final private function __wakeup(){}

    final public static function getClient(): ?Redis
    {
        $redis = new Redis();
        $redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);

        if (self::$client === null) {
            self::$client = new Redis();
            self::$client->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        }

        return self::$client;
    }

    final private function __destruct()
    {
        self::$client->close();
    }
}