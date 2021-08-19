<?php

namespace app\Exceptions\Validator;


use Exception;
use app\Logger\ApplicationLogger;
use Monolog\Logger;


class BadValidatorException extends \Exception
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
        $message = "Validator error: " . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}