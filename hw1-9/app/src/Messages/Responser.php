<?php
namespace Src\Messages;

/**
 * Class Responser
 *
 * @package App\Messages
 */
class Responser
{
    public static function responseOk(): void
    {
        http_response_code(200);
        echo 'Query is successful';
    }

    /**
     * @param $message
     *
     * @throws \Exception
     */
    public static function responseFail(string $message = 'Something went wrong'): void
    {
        http_response_code(400);
        throw new \Exception($message . PHP_EOL . 'Query is not successful');
    }
}