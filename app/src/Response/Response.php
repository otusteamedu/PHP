<?php

namespace App\Response;

class Response
{
    public const OK = 200;
    public const BAD_REQUEST = 400;
    public const UNPROCESSABLE_ENTITY = 422;
    public const SERVER_ERROR = 500;

    public static function send($code = 200, $message = '', $data = [])
    {
        $code = $code === 0 ? self::SERVER_ERROR : $code;

        http_response_code($code);
        header('Content-Type: application/json');
        $status = array(
            self::OK                    => '200 OK',
            self::BAD_REQUEST           => '400 Bad Request',
            self::UNPROCESSABLE_ENTITY  => 'Unprocessable Entity',
            self::SERVER_ERROR          => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);

        $result['status'] = $code < 300 ? "success" : "error";
        $result['message'] = $message;
        $result['data'] = $data;

        echo json_encode($result);
    }
}