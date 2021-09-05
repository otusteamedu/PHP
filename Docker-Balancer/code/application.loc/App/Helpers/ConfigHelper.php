<?php

namespace App\Helpers;


use JetBrains\PhpStorm\ArrayShape;

/**
 * Предоставляет набор конфигурационных параметров
 */
class ConfigHelper
{
    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'dbname' => "mixed",
        'user' => "mixed",
        'pass' => "mixed"
    ])]
    public static function getConnectionConfigMysqlMaster(): array
    {
        return [
            'host' => $_ENV['MYSQL_MASTER_HOST'],
            'port' => $_ENV['MYSQL_MASTER_PORT'],
            'dbname' => $_ENV['MYSQL_MASTER_DB'],
            'user' => $_ENV['MYSQL_MASTER_USER'],
            'pass' => $_ENV['MYSQL_MASTER_PASSWORD'],
        ];
    }

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'dbname' => "mixed",
        'user' => "mixed",
        'pass' => "mixed"
    ])]
    public static function getConnectionConfigMysqlSlave(): array
    {
        return [
            'host' => $_ENV['MYSQL_SLAVE_HOST'],
            'port' => $_ENV['MYSQL_SLAVE_PORT'],
            'dbname' => $_ENV['MYSQL_SLAVE_DB'],
            'user' => $_ENV['MYSQL_SLAVE_USER'],
            'pass' => $_ENV['MYSQL_SLAVE_PASSWORD'],
        ];
    }

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

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'timeout' => "mixed",
        'reserved' => "mixed",
        'retryInterval' => "mixed",
        'readTimeout' => "mixed"
    ])]
    public static function getConnectionConfigRedis(): array
    {
        return [
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
            'timeout' => $_ENV['REDIS_READ_TIMEOUT'],
            'reserved' => $_ENV['REDIS_RESERVED'],
            'retryInterval' => $_ENV['REDIS_RETRY_INTERVAL'],
            'readTimeout' => $_ENV['REDIS_READ_TIMEOUT'],
        ];
    }

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed"
    ])]
    public static function getConnectionConfigElasticsearch(): array
    {
        return [
            'host' => $_ENV['ELASTICSEARCH_HOST'],
            'port' => $_ENV['ELASTICSEARCH_PORT'],
        ];
    }

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'driver' => "mixed"
    ])]
    public static function getConnectionConfigMemCached(): array
    {
        return [
            'host' => $_ENV['MEMCACHED_HOST'],
            'port' => $_ENV['MEMCACHED_PORT'],
            'driver' => $_ENV['MEMCACHED_DRIVER'],
        ];
    }

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'driver' => "mixed"
    ])]
    public static function getConnectionConfigMemCached1(): array
    {
        return [
            'host' => $_ENV['MEMCACHED_1_HOST'],
            'port' => $_ENV['MEMCACHED_1_PORT'],
            'driver' => $_ENV['MEMCACHED_DRIVER'],
        ];
    }

    #[ArrayShape([
        'host' => "mixed",
        'port' => "mixed",
        'driver' => "mixed"
    ])]
    public static function getConnectionConfigMemCached2(): array
    {
        return [
            'host' => $_ENV['MEMCACHED_2_HOST'],
            'port' => $_ENV['MEMCACHED_2_PORT'],
            'driver' => $_ENV['MEMCACHED_DRIVER'],
        ];
    }

}