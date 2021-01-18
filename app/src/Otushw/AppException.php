<?php


namespace Otushw;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Throwable;
use Exception;

class AppException extends Exception
{
    protected LoggerFactory $log;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->log = new LoggerFactory($type = 'file');
        $this->addTolog($message);
    }

    protected function addTolog(string $message)
    {
        $this->log->log($this->log->getLevelApp(), $message);
    }
}