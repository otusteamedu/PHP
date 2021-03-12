<?php

namespace Otus\Exceptions;

use Monolog\Logger;
use Otus\Logger\AppLogger;
use Throwable;

class ValidationException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        http_response_code($code);
        AppLogger::addLog(Logger::ERROR, $message);
    }
}