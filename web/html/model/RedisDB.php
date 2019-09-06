<?php

use Predis\Client;

namespace model;

class RedisDB {
    private static $single_server  = array(
        'host'     => 'redis',
        'port'     => 6379,
        'database' => 15
    );

    public static function setEvent($data) {
        $redis = new \Predis\Client(self::$single_server);   
        $key = 'event_' . microtime();
        $redis->set($key, $data);        
    }

    public static function getAllEvents() {
        $events =array();
        $redis = new \Predis\Client(self::$single_server);   
        foreach ($redis->keys("event_*") as $key ) {
           $events[] = $redis->get($key);
        }
        return $events;
    }

    public static function dellAllEvents() {
        $redis = new \Predis\Client(self::$single_server);   
        foreach ($redis->keys("event_*") as $key ) {            
            $redis->del($key);            
        }        
    }
}