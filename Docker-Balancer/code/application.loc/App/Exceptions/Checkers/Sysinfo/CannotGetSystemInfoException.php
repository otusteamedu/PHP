<?php

namespace App\Exceptions\Checkers\Sysinfo;


use App\Exceptions\INotLogged;
use App\Exceptions\IOutable;
use Exception;


class CannotGetSystemInfoException extends Exception implements IOutable, INotLogged
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
        $message = "System information error: " . $message;
        parent::__construct($message, $code, $previous);
    }
}