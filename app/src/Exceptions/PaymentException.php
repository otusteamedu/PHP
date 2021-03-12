<?php


namespace Otus\Exceptions;


use Monolog\Logger;
use Otus\Logger\AppLogger;
use Throwable;

class PaymentException extends \Exception
{
    const PAYMENT_ERROR_CODE = 403;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        header('Content-Type: application/json');
        http_response_code($code);
        AppLogger::addLog(Logger::ALERT, $message);
    }
}