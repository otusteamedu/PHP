<?php

namespace App\Exceptions\Orders;


use App\Exceptions\ILogged;
use App\Exceptions\IOutable;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Неправильно приготовленный продукт
 */
class InvalidProductOrderException extends Exception implements ILogged, IOutable
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        $message = "Product cooking error." . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}