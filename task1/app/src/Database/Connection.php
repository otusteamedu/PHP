<?php


namespace App\Database;


use App\Database\Drivers\Driver;

class Connection
{
    private static $conn;

    private function __construct()
    {
    }

    public static function getWrappedConnection(Driver $driver)
    {
        if (self::$conn === null) {
            self::$conn = $driver->getConnection();
        }
        return self::$conn;
    }
}