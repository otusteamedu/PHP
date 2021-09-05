<?php

namespace App\Services\Checkers;

use App\Exceptions\Checkers\InvalidCheckerException;
use App\Exceptions\ErrorCodes;
use App\Helpers\ConfigHelper;
use App\Services\Checkers\NoSql\ElasticsearchChecker;
use App\Services\Checkers\NoSql\MemcachedChecker;
use App\Services\Checkers\NoSql\RedisChecker;
use App\Services\Checkers\Sql\Mysql\MySQLiteChecker;
use App\Services\Checkers\Sql\Mysql\MysqlPdoChecker;
use App\Services\Checkers\Sql\Postgres\PostgresPdoChecker;
use App\Services\Checkers\Sql\Postgres\PostgresPgConnectChecker;
use App\Services\Checkers\Sysinfo\NodeAddressChecker;
use App\Services\Checkers\Sysinfo\SapiChecker;
use App\Services\Checkers\Sysinfo\ServerAddressChecker;


class CheckersFactory
{
    /**
     * Фабрика создающая конкретный Checkers
     * реализованы следующие Checkers-ы:
     * 1) PostgresPgConnectChecker - проверяет подключение базы данных Postgres через PgConnect
     * 2) MysqlPdoCheckerMaster - проверяет подключение базы данных Mysql-master через PDO
     * 3) MysqlPdoCheckerSlave - проверяет подключение базы данных Mysql-slave через PDO
     * 4) MySQLiteCheckerMaster - проверяет подключение базы данных Mysql-master через MySQLi
     * 5) MySQLiteCheckerSlave - проверяет подключение базы данных Mysql-slave через MySQLi
     * 6) RedisChecker - проверяет подключение к базе Redis
     * 7) ElasticsearchChecker - проверяет подключение к базе Memcached
     * 8) MemcachedChecker - проверяет подключение к базе Memcached
     *
     * @param string $checkerName
     * @param array $config
     * @return AbstractChecker
     * @throws InvalidCheckerException
     */
    public static function make(string $checkerName, array $config): AbstractChecker
    {
        return match ($checkerName) {
            PostgresPdoChecker::class                           => new PostgresPdoChecker($config),
            PostgresPgConnectChecker::class                    => new PostgresPgConnectChecker($config),
            MysqlPdoChecker::class                             => new MysqlPdoChecker($config),
            MySQLiteChecker::class                             => new MySQLiteChecker($config),
            RedisChecker::class                                => new RedisChecker($config),
            ElasticsearchChecker1::class                        => new ElasticsearchChecker($config),
            MemcachedChecker::class                            => new MemcachedChecker($config),
            default => throw new InvalidCheckerException("Unknown checker '$checkerName'", ErrorCodes::getCode(InvalidCheckerException::class)),
        };
    }
}