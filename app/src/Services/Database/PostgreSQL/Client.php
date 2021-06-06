<?php


namespace App\Services\Database\PostgreSQL;

use PDO;

class Client
{
    private ?PDO $client = null;
    private static ?self $instance = null;

    private function __construct()
    {
        $this->client = new PDO(
            'pgsql:host=' . env('POSTGRESQL_HOST') . ';' .
            'port=' . env('POSTGRESQL_PORT') . ';' .
            'dbname=' . env('POSTGRESQL_DATABASE') . ';' .
            'user=' . env('POSTGRESQL_USER') . ';' .
            'password=' . env('POSTGRESQL_PASSWORD'),
        );
    }

    public static function get(): PDO
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance->client;
    }
}