<?php
namespace AlexRedis;


class Report
{

    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->pconnect('127.0.0.1', 6379);
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    public function testRedis()
    {
        echo $this->redis->ping('hello');
    }



}