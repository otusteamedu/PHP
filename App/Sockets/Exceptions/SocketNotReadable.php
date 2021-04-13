<?php


namespace App\Sockets\Exceptions;


use Throwable;

class SocketNotReadable extends \Exception
{

    public function __construct($message = "Can not read from socket", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}