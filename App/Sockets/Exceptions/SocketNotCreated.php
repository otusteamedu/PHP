<?php

namespace App\Sockets\Exceptions;


use Throwable;

class SocketNotCreated extends \Exception
{

    public function __construct($message = "Socket is not created", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}