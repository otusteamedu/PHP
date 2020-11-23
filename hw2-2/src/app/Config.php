<?php


namespace app;

class Config
{
    static $config = null;
    public static function get()
    {
        if (is_null(self::$config)) {
            $dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
            self::$config = $dotenv->load();
        }
        return self::$config;
    }
}