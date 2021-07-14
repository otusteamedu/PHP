<?php

namespace App\Exceptions;

use App\Logger\AppLogger;
use Exception;
use Monolog\Logger;

class AppException extends Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        AppLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}