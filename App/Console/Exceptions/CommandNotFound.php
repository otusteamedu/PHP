<?php

namespace App\Console\Exceptions;

use Exception, Throwable;

class CommandNotFound extends Exception
{
    public function __construct($command = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Command \"$command\" not found", $code, $previous);
    }
}