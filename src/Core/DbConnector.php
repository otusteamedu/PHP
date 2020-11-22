<?php

namespace App\Core;

use SQLite3;

class DbConnector
{
    private static ?SQLite3 $db = null;

    private function __construct()
    {
    }

    private static function getInstance(): SQLite3
    {
        if (static::$db === null) {
            static::$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/src/Db/TaskStatus.db');
        }

        return static::$db;
    }

    private static function closeConnection(): void
    {
        static::$db = null;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}