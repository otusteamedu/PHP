<?php
namespace Otus\Exceptions;

use Exception;
use Monolog\Logger;
use Otus\Logger\AppLogger;
use Throwable;

class AppException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        http_response_code($code);
        AppLogger::addLog(Logger::ERROR, $message);
    }
}