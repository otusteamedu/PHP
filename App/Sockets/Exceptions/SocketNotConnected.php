<?php


namespace App\Sockets\Exceptions;


use Throwable;

class SocketNotConnected extends \Exception
{

    public function __construct($message = "Socket is not connected", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}