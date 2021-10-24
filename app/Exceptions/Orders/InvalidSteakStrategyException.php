<?php

namespace App\Exceptions\Orders;


use App\Exceptions\ILogged;
use App\Exceptions\IOutable;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Неверная стратегия приготовления стейка
 */
class InvalidSteakStrategyException extends Exception implements ILogged, IOutable
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        $message = "Steak cooking error." . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}