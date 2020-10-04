<?php

namespace Otus\Exceptions;

use Exception;
use Throwable;

class InvalidEventDataException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: 'Event data format is invalid', $code, $previous);
    }
}
