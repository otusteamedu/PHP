<?

namespace App;

class Response
{
    public static function sendOk(string $message = '')
    {
        header("HTTP/1.1 200 OK");
        echo $message;
    }

    public static function sendFail(string $message = '')
    {
        header("HTTP/1.0 400 Bad Reques");
        echo $message;
    }
}
