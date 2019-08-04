<?php

namespace App\Models;

class DBRedis
{
    protected static $redis;
    protected static $hash_key = 'events';

    protected static function connect()
    {
        static::$redis = new \Redis();

        static::$redis->connect('127.0.0.1', 6379);
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
            die;
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
            die;
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