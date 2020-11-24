<?php

namespace app\storage;

use app\events\IEvent;
use Predis\Client;

class RedisStorage implements IEventStorage
{
    const DBKEY = 'events';
    private $client;

    public function __construct($conn = []){
        if (empty($conn))
        $conn = [
            'host' => '127.0.0.1',
            'port' => 6379,
            'read_write_timeout' => 0
        ];

        $this->client = new Client($conn);

}
    public function save(IEvent $event)
    {
        $this->client->hmset(self::DBKEY, (array) $event);
    }


    public function fetchAll()
    {
        return $this->client->hmget(self::DBKEY, []);
    }


    public function clear()
    {
        $this->client->hmset(self::DBKEY, []);
    }
}