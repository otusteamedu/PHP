<?php

namespace App\Storage;

use App\Config\Config;
use App\Log\Log;
use PDO;

class MysqlConnection
{
    public const STORAGE_NAME = 'mysql';

    public const CONFIG_KEYS = [
        'host',
        'port',
        'user',
        'password',
        'dbname',
    ];

    public static function get()
    {
        MysqlConfigValidator::validate(self::CONFIG_KEYS);

        $pdo = new PDO(self::getDsn());

        return $pdo;
    }

    private static function getDsn()
    {
        $dbConfig = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY);

        $host     = $dbConfig['host'] ?? '';
        $port     = $dbConfig['port'] ?? '';
        $user     = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';
        $dbname   = $dbConfig['dbname'] ?? '';

        return "mysql:host={$host};port={$port};user={$user};password={$password};dbname={$dbname}";
    }
}