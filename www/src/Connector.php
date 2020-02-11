<?php

namespace Tirei01\Hw12;

class Connector
{

    private static $connect;

    private function __construct()
    {

    }

    /**
     * Connect to db
     * @return \PDO
     */
    public static function getConnection(string $dsn): \PDO
    {
        if(is_null(static::$connect)){
            static::$connect = new \PDO($dsn);
        }
        return static::$connect;
    }

}