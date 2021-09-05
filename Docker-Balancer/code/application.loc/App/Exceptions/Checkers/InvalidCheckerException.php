<?php

namespace App\Exceptions\Checkers;


use App\Exceptions\ILogged;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Неправильный (отсутствует) класс Checker
 */
class InvalidCheckerException extends Exception implements ILogged
{
    /**
     * Конструктор класса
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        $this->message = "Checker error: ";
        ApplicationLogger::addLog(Logger::ERROR, $this->message . $message);
        parent::__construct($this->message, $code, $previous);
        return $this;
    }
}