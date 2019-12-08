<?php

namespace App\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}





