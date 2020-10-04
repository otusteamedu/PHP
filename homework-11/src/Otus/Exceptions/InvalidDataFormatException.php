<?php

namespace Otus\Exceptions;

use Exception;
use Throwable;

class InvalidDataFormatException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Data format is invalid', $code, $previous);
    }
}