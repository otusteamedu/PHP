<?php

namespace EmailValidator\Exceptions;

use EmailValidator\Logger\AppLogger;
use Exception;
use Monolog\Logger;

class AppException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        http_response_code($code);
        AppLogger::addLog(Logger::ERROR, $message);
    }
}