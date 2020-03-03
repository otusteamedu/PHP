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
    public static function getConnection(): \PDO
    {
        if(is_null(static::$connect)){
            $host = 'db';
            $db = 'hw5';
            $username = 'postgres';
            $password = 'newDAy01';
            $dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
            static::$connect = new \PDO($dsn);
        }
        return static::$connect;
    }

}