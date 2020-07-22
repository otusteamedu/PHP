<?php

namespace Classes\Database;

class RedisDb implements Driver
{
    public function getConnection()
    {
        return new \Redis();
    }
}
