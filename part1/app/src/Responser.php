<?php

namespace App;

/**
 * Class Responser
 *
 * @package App
 */
class Responser
{
    public static function responseOk(): void
    {
        http_response_code(200);
        echo 'String is valid';
    }

    /**
     * @param $message
     *
     * @throws \Exception
     */
    public static function responseFail(string $message = 'Something went wrong'): void
    {
        http_response_code(400);
        throw new \Exception($message . PHP_EOL . 'String is not valid');
    }
}