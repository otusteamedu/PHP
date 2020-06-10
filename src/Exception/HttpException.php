<?php

namespace App\Exception;

use Exception;
use Throwable;

class HttpException extends Exception
{
    public function __construct(int $code, string $message = '', ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
