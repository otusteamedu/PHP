<?php


namespace App\Messages;


class MessageWeb
{
    public const STATUS_OK = 200;
    public const STATUS_BAD_REQUEST = 400;
    /**
     * @var array
     */
    public static array $httpStatuses = [
        self::STATUS_OK => 'OK',
        self::STATUS_BAD_REQUEST => 'Bad Request',
    ];

    /**
     * @param $text
     * @return null
     */
    public static function sendOk(string $text)
    {
        header("HTTP/1.1 ".self::STATUS_OK." ". self::$httpStatuses[self::STATUS_OK]);
        echo $text;
        return null;
    }

    /**
     * @param $text
     * @return null
     */
    public static function sendError(string $text)
    {
        header("HTTP/1.1 ".self::STATUS_BAD_REQUEST." ". self::$httpStatuses[self::STATUS_BAD_REQUEST]);
        echo $text;
        return null;
    }
}