<?php


namespace App\Exceptions;


use Throwable;

class IsEmptyException extends \Exception
{
    public function __construct($argument = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("The $argument is empty", $code, $previous);
    }
}