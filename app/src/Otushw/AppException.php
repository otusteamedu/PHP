<?php


namespace Otushw;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Exception;
use Throwable;

class AppException extends Exception
{
    protected Logger $log;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler('../app.log'));
        $this->log = $log;
        $this->log($message);
    }

    public function log(string $msg)
    {
        $this->log->addRecord(Logger::ERROR, $msg);
    }
}