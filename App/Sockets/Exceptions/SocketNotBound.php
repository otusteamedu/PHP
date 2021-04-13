<?php


namespace App\Sockets\Exceptions;



use Throwable;

class SocketNotBound extends \Exception
{
    public function __construct($message = "Socket is not bound", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}