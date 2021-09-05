<?php

namespace App\Exceptions;


use App\Exceptions\Checkers\Sysinfo\CannotGetSystemInfoException;
use App\Exceptions\Connection\CannotConnectElasticsearchException;
use App\Exceptions\Connection\CannotConnectMemcachedException;
use App\Exceptions\Connection\CannotConnectElasticsearch;
use App\Exceptions\Connection\CannotConnectPostgresException;
use App\Exceptions\Connection\CannotConnectRedisException;
use App\Exceptions\Connection\CannotConnectMySqlException;
use App\Exceptions\Checkers\InvalidCheckerException;
use App\Exceptions\Connection\InvalidArgumentException;
use App\Exceptions\Loader\ViewLoaderException;
use App\Exceptions\Router\InvalidRouteException;

/**
 * Содержит коды ошибок проекта
 */
class ErrorCodes
{
    /**
     * @var array|int[]
     */
    private static array $errorCodes = [
        InvalidRouteException::class                => 700,
        InvalidCheckerException::class              => 701,
        InvalidArgumentException::class             => 702,
        CannotGetSystemInfoException::class         => 801,
        CannotConnectPostgresException::class       => 802,
        CannotConnectMySqlException::class          => 803,
        CannotConnectRedisException::class          => 804,
        CannotConnectMemcachedException::class      => 805,
        CannotConnectElasticsearchException::class  => 806,
        ViewLoaderException::class                  => 900,
    ];

    /**
     * @param string $codeName
     * @return int
     */
    public static function getCode(string $codeName = ''): int
    {
        return self::$errorCodes[$codeName] ?? 0;
    }

    /**
     * @param int $code
     * @return string|false
     */
    public static function getMessage(int $code): string|false
    {
        return array_search($code, self::$errorCodes);
    }
}