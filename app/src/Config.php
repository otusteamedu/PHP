<?php

namespace Otus\HW11;

class Config
{
    protected static $instance;

    protected $config;

    protected function __construct()
    {
        $this->config = parse_ini_file(dirname(__DIR__) . '/config.ini', true);
    }


    protected function __clone()
    {
    }


    protected function __wakeup()
    {
    }

    protected function getConfigVal(string $param): array
    {
        return $this->config[$param];
    }

    /**
     * @param string $param
     * @return mixed
     */
    public static function get(string $param): array
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->getConfigVal($param);
    }
}
