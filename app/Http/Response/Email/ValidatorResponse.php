<?php

namespace app\Http\Response\Email;

class ValidatorResponse
{
    public const OK             = 200;
    public const BAD_REQUEST    = 400;
    public const BAD_VALIDATOR  = 404;
    public const SERVER_ERROR   = 500;

    /**
     * Возвращает данные
     *
     * @param int $code
     * @param string $message
     * @param array $data
     */
    static public function sendData(int $code = 200, string $message = "", array $data = []): void
    {
        $code = ($code === 0)
            ? self::SERVER_ERROR
            : $code;
        http_response_code($code);
        header('Content-Type: application/json');
        $status = array(
            self::OK                    => '200 OK',
            self::BAD_REQUEST           => '400 Bad Request',
            self::BAD_VALIDATOR         => '404 Validator Not Found',
            self::SERVER_ERROR          => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);

        $result['status'] = $code < 300 ? "success" : "error";
        $result['message'] = $message;
        $result['data'] = $data;

        echo json_encode($result);
    }
}