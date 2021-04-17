<?php
namespace Src\Messages;

use Src\Exceptions\DataParserException;

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
        http_response_code(500);
        throw new \Exception($message . PHP_EOL . 'Query is not successful');
    }

    /**
     * @param string $message
     *
     * @throws DataParserException
     */
    public static function responseParseDataFail(string $message = 'Something went wrong'): void
    {
        http_response_code(500);
        throw new DataParserException($message);
    }
}