<?php

namespace App\Exception;

class SocketException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(socket_strerror(socket_last_error()), $code, $previous);
    }
}