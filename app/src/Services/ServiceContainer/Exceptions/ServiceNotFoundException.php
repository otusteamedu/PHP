<?php


namespace App\Services\ServiceContainer\Exceptions;


use Throwable;

class ServiceNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}