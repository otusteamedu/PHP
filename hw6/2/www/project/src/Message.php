<?php


namespace App;

/**
 * Class Message
 * @package App
 */
class Message
{

    const STATUS_OK = 200;
    /**
     * @var array
     */
    public static $httpStatuses = [
        self::STATUS_OK => 'OK',
    ];

    /**
     * @return bool
     */
    public static function sendJsonOk()
    {
        header("HTTP/1.1 ".self::STATUS_OK." ". self::$httpStatuses[self::STATUS_OK]);
        echo $_SERVER;
        return true;
    }

}
