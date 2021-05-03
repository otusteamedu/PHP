<?php

namespace Src\Messages;

use Src\Exceptions\DataBaseApiException;

/**
 * Generate answers for API requests
 */
class Responser
{
    /**
     * Response for failed user data
     * @param $message
     * @throws \Exception
     */
    public static function responseFailData(string $message = 'Something went wrong'): void
    {
        http_response_code(400);
        throw new \Exception($message . PHP_EOL . 'Your data is failed');
    }

    /**
     * Response for database API
     * @param string $message
     * @throws \Src\Exceptions\DataBaseApiException
     */
    public static function responseDataBaseFailed(string $message = 'Something went wrong'): void
    {
        http_response_code(500);
        throw new DataBaseApiException($message);
    }

    /**
     * Response when all correct
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