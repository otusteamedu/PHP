<?php

namespace App\Exceptions\Loader;


use App\Exceptions\ILogged;
use App\Exceptions\IOutable;
use Exception;
use App\Logger\ApplicationLogger;
use Monolog\Logger;

/**
 * Ошибка при загрузке View-файла.
 */
class ViewLoaderException extends Exception implements ILogged, IOutable
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
        $message = "ViewLoad error: " . $message;
        ApplicationLogger::addLog(Logger::ERROR, $message);
        parent::__construct($message, $code, $previous);
    }
}