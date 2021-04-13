<?php


namespace App\Sockets\Exceptions;


use Throwable;

class SocketNotAccepted extends \Exception
{
public function __construct($message = "Socket is not accepted", $code = 0, Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}