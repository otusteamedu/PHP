<?php

namespace App;

use App\Console\Console;
use PDO;

final class App
{
    private static ?PDO $pdo = null;

    /**
     * App constructor.
     *
     * @phan-suppress PhanNoopNew
     */
    public function __construct()
    {
        new ErrorHandler();
        if ('cli' === PHP_SAPI) {
            new Console();
        } else {
            Router::dispatch();
        }
    }

    public static function getEnv(): string
    {
        return getenv('APP_ENV') ?: 'prod';
    }

    public static function getPDO(): PDO
    {
        if (null === self::$pdo) {
            self::$pdo = new PDO(
                getenv('APP_DB_DSN'),
                getenv('APP_DB_USER'),
                getenv('APP_DB_PWD'),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }
}
