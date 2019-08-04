<?php

namespace App\Models;

class DBRedis
{
    protected static $redis;
    protected static $hash_key = 'events';

    protected static function connect()
    {
        static::$redis = new \Redis();
        $conn = include __DIR__ . '/../../connect.php';
        static::$redis->connect($conn['host'], $conn['port']);
    }

    public static function add(array $events)
    {
        try {
            static::connect();
            foreach ($events as $key => $event) {
                static::$redis->hSet(static::$hash_key, $key, serialize($event));
            }
        } catch (\Exception $exception) {
            echo($exception->getMessage());
        }

    }

    public static function getAll()
    {
        try {
            static::connect();

            $data = static::$redis->hGetAll(static::$hash_key);
            $objects = [];
            foreach ($data as $key => $datum) {
                $objects[$key] = (unserialize($datum));
            }
            return $objects;
        } catch (\Exception $exception) {
            echo($exception->getMessage());
        }


    }

    public static function deleteOne($key)
    {

        static::connect();
        static::$redis->hdel(static::$hash_key, $key);

    }

    public static function deleteAll()
    {
        static::connect();
        static::$redis->del(static::$hash_key);
    }


}