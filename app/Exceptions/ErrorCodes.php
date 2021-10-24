<?php

namespace App\Exceptions;


use App\Exceptions\Loader\ViewLoaderException;
use App\Exceptions\Orders\InvalidProductOrderException;
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
        InvalidProductOrderException::class         => 701,
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