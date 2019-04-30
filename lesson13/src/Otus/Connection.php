<?php

namespace Otus;

use PDO;

/**
 * Represent the Connection
 */
class Connection
{

    /**
     * Connection
     * @var type
     */
    private static $conn;


    /**
     * Connection to db
     * @param string $host
     * @param int $port
     * @param string $database
     * @param string $user
     * @param string $password
     * @return PDO
     */
    public function connect($host, $port, $user, $password, $database = null)
    {

        // connect to the postgresql database
        $conStr = sprintf("pgsql:host=%s;port=%d;%suser=%s;password=%s",
            $host,
            $port,
            $database ? "dbname=$database;" : '',
            $user,
            $password);

        $pdo = new PDO($conStr);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get()
    {
        if (null === static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }

}