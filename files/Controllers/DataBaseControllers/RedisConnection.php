<?php
namespace Controllers\DataBaseControllers;

use mysql_xdevapi\Exception;
use \RedisException;

class RedisConnection {
    public $redis = null;
    private $host = '172.22.0.1';
    private $port = 6379;
    private $password = '';

    public function __construct()
    {
        $this->redis = new \Redis();

        try {
            $this->connectRedis();
        } catch (RedisException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * функция соединения с redis
     */
    private function connectRedis()
    {
        if (!$this->redis->connect($this->host, $this->port)) {
            throw new RedisException('Хост или пароль указаны неверно');
        }

        $this->redis->auth($this->password);

    }
}