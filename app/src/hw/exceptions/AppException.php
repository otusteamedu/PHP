<?php
namespace VideoPlatform\exceptions;

use Exception;
use Monolog\Logger;
use Throwable;
use VideoPlatform\loggers\AppLogger;

class AppException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        AppLogger::addLog(Logger::ERROR,$message);
    }
}