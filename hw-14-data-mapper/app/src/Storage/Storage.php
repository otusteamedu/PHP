<?php

namespace App\Storage;

use App\Config\Config;
use App\Singleton\Singleton;
use PDO;

class Storage extends Singleton
{
    public const DB_CONFIG_KEY  = 'db';
    public const DB_STORAGE_KEY = 'storage';

    private static $pdo = null;

    public static function getInstance ()
    {
        if (!is_null(self::$pdo)) {
            return self::$pdo;
        }

        self::$pdo = self::getNewConnection();

        return self::$pdo;
    }

    private static function getNewConnection()
    {
        $storage = Config::getInstance()->getItem(self::DB_CONFIG_KEY)[self::DB_STORAGE_KEY];

        if ($storage === MysqlConnection::STORAGE_NAME) {
            return (new MysqlConnection())::get();
        }
    }
}