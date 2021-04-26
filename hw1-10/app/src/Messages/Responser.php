<?php

namespace Src\Messages;

use Src\Exceptions\DataBaseException;

/**
 * Class Responser
 *
 * @package Src\Messages
 */
class Responser
{
    /**
     * @param $message
     *
     * @throws \Exception
     */
    public static function responseFailData(string $message = 'Something went wrong'): void
    {
        http_response_code(400);
        throw new \Exception($message . PHP_EOL . 'Your data is failed');
    }

    /**
     * @param string $message
     *
     * @throws \Src\Exceptions\DataBaseException
     */
    public static function responseDataBaseFailed(string $message = 'Something went wrong'): void
    {
        http_response_code(500);
        throw new DataBaseException($message);
    }

    /**
     * @return string
     */
    public static function responseOk(): string
    {
        return \GuzzleHttp\json_encode(
            [
                'result' => 'success',
                'message' => 'query for url - http://' . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . ' is successful',
            ]
        );
    }
}