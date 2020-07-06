<?php


namespace App\Database;


use App\Database\Drivers\Redis as Driver;

abstract class RedisManager
{
    /* @var $conn \Redis */
    protected $conn;

    public function __construct()
    {
        $this->conn = Connection::getWrappedConnection(new Driver());
    }
}