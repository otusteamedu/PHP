<?php
namespace Controllers\DataBaseControllers;

use \RedisException;
use \Config\ConfigGetter;

class RedisConnection {
    public $redis = null;
    private $config;
    private $host = '127.0.0.1';
    private $port = 6379;
    private $password = '';

    public function __construct()
    {
        $this->config = ConfigGetter::config('redis');
        $this->host = $this->config->host;
        $this->port = $this->config->port;
        $this->password = $this->config->password;
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