<?php

namespace App\Helpers;


use JetBrains\PhpStorm\ArrayShape;

/**
 * Предоставляет набор конфигурационных параметров
 */
class ConfigHelper
{
    #[ArrayShape(['host' => "mixed",
        'port' => "mixed",
        'dbname' => "mixed",
        'user' => "mixed",
        'pass' => "mixed"
    ])]
    public static function getConnectionConfigPostgres(): array
    {
        return [
            'host' => $_ENV['PGSQL_DB_HOST'],
            'port' => $_ENV['PGSQL_DB_PORT'],
            'dbname' => $_ENV['PGSQL_DB_NAME'],
            'user' => $_ENV['PGSQL_DB_USER'],
            'pass' => $_ENV['PGSQL_DB_PASSWORD'],
        ];
    }
}