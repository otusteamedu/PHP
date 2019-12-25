<?

namespace App;

class Response
{
    public static function sendOk(string $message = '')
    {
        header("HTTP/1.1 200 OK");
        echo $message;
        die();

    }

    public static function sendFail(string $message = '')
    {
        header("HTTP/1.0 404 Not Found");
        echo $message;
        die();
    }
}