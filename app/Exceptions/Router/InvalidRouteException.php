<?php

namespace App\Exceptions\Router;


use App\Exceptions\ILogged;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Ошибки маршрутизатора
 */
class InvalidRouteException extends Exception implements ILogged
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        $this->message = "Router error: ";
        ApplicationLogger::addLog(Logger::ERROR, $this->message . $message);
        parent::__construct($this->message, $code, $previous);
    }
}