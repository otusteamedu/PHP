<?php


namespace App;

/**
 * Class Message
 * @package App
 */
class Message
{

    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNPERFORMED = 501;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    /**
     * @var array
     */
    public static $httpStatuses = [
        self::STATUS_OK => 'OK',
        self::STATUS_BAD_REQUEST => 'Bad Request',
        self::STATUS_INTERNAL_SERVER_ERROR => 'internal server error',
        self::STATUS_UNPERFORMED => 'unperformed',
    ];

    /**
     * @return bool
     */
    public static function sendJsonOk()
    {
        header("HTTP/1.1 ".self::STATUS_OK." ". self::$httpStatuses[self::STATUS_OK]);
        header('Content-type: application/json');
        $data = [
            'status' => self::STATUS_OK,
            'data' => self::$httpStatuses[self::STATUS_OK]
        ];
        echo json_encode($data);
        return true;
    }

    public static function sendJsonByStatus($error, $status)
    {
        header("HTTP/1.1 ".$status." ". self::$httpStatuses[$status]);
        header('Content-type: application/json');
        echo json_encode($error);
        return true;
    }

    /**
     * @param array $errors
     * @return bool
     */
    public static function sendJsonErrors(array $errors)
    {
        header("HTTP/1.1 ".self::STATUS_BAD_REQUEST." ". self::$httpStatuses[self::STATUS_BAD_REQUEST]);
        header('Content-type: application/json');
        echo json_encode($errors);
        return true;
    }
}
