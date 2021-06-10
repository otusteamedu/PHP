<?php


namespace App\Exceptions;


use Throwable;

class IsNullException extends \Exception
{
    public function __construct($argument = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("The $argument is null", $code, $previous);
    }
}