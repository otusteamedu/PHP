<?php


namespace App;


use Exception;

class Message
{

    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;

    public static $httpStatuses = [
        self::STATUS_OK => 'OK',
        self::STATUS_BAD_REQUEST => 'Bad Request',
    ];

    public static function sendOk()
    {
        header("HTTP/1.1 ".self::STATUS_OK." ". self::$httpStatuses[self::STATUS_OK]);
        return true;
    }

    /**
     * @throws Exception
     */
    public static function sendError()
    {
        header("HTTP/1.1 ".self::STATUS_BAD_REQUEST." ". self::$httpStatuses[self::STATUS_BAD_REQUEST]);
        return true;
    }
}