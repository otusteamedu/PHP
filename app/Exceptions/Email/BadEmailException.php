<?php

namespace app\Exceptions\Email;


use Exception;
use app\Logger\ApplicationLogger;
use Monolog\Logger;


class BadEmailException extends Exception
{
    /**
     * Конструктор класса
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = "Email error: " . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}