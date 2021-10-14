<?php

namespace App\Http\Response\Helpers;

/**
 * Содержит статус коды для ответа
 */
class StatusCodes
{
    public const OK             = 200;
    public const BAD_REQUEST    = 400;
    public const NOT_FOUND      = 404;
    public const SERVER_ERROR   = 500;

    /**
     * @var array|int[]
     */
    private static array $responseCodes = [
        '200 OK'                                => 200,
        '400 Bad Request'                       => 400,
        '404 Not found'                         => 404,
        '500 Internal server Error'             => 500,
    ];

    /**
     * @param string $codeName
     * @return int
     */
    public static function getCode(string $codeName = ''): int
    {
        return self::$responseCodes[$codeName] ?? 0;
    }

    /**
     * @param int $code
     * @return string|false
     */
    public static function getMessage(int $code): string|false
    {
        $msg = array_search($code, self::$responseCodes);
        return  ($msg !== false)
            ? $msg
            : array_search(self::OK, self::$responseCodes);
    }
}