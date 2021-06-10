<?php


namespace App\Sockets\Exceptions;


use Throwable;

class SocketNotListening extends \Exception
{
    public function __construct($message = "Socket is not listening", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}