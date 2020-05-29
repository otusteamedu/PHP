<?php

namespace HW5;

use Exception;
use Throwable;

/**
 * Class HttpException
 * @package HW5
 */
class HttpException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        http_response_code($code);
    }
}