<?php

namespace App\Storage;

use App\Models\DTO\EventDTO;
use Redis;

class RedisStorage extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function store(EventDTO $eventDTO)
    {

    }
}