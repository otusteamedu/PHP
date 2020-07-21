<?php


namespace Classes\Database;


class DbConnectionImpl implements DbConnection
{

    private static $connection;

    private function __construct()
    {
    }

    /**
     * @param Driver $driver
     * @return mixed
     */
    public static function getConnection(Driver $driver)
    {
        if (self::$connection === null) {
            self::$connection = $driver->getConnection();
        }
        return self::$connection;
    }
}
