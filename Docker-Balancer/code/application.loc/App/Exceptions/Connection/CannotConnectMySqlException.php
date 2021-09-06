<?php

namespace App\Exceptions\Connection;


use App\Exceptions\ILogged;
use App\Exceptions\IOutable;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Ошибка подключения к серверу MySql
 */
class CannotConnectMySqlException extends Exception implements ILogged, IOutable
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        $message = "MySQL connection error: " . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}