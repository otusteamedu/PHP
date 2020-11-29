<?php

namespace App\Core;

use SQLite3;

class DbConnector
{
    private static ?SQLite3 $db = null;

    private function __construct()
    {
    }

    public static function getInstance(): SQLite3
    {
        if (static::$db === null) {
            static::$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/src/Db/TaskStatus.db');
        }

        return static::$db;
    }

    public static function closeConnection(): void
    {
        static::$db = null;
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }

}