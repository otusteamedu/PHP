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
    ];

    public static function get()
    {
        MysqlConfigValidator::validate(self::CONFIG_KEYS);

        $pdo = new PDO(self::getDsn());

        $dbname = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY)['dbname'];
        self::createDatabaseIfNotExists($pdo, $dbname);
        self::setDatabase($pdo, $dbname);

        return $pdo;
    }

    private static function getDsn()
    {
        $dbConfig = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY);

        $host     = $dbConfig['host'] ?? '';
        $port     = $dbConfig['port'] ?? '';
        $user     = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        return "mysql:host={$host};port={$port};user={$user};password={$password}";
    }

    private static function createDatabaseIfNotExists (PDO $pdo, string $dbname): void
    {
        Log::getInstance()->addRecord('detecting db...');
        $sql  = "CREATE DATABASE IF NOT EXISTS cinema CHARACTER SET utf8 COLLATE utf8_general_ci;";
        $pdo->query($sql);
    }

    private static function setDatabase (PDO $pdo, string $dbname): void
    {
        Log::getInstance()->addRecord('selecting db...');
        $sql  = "USE cinema";

    }
}