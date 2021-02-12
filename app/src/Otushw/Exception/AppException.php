<?php


namespace Otushw\Exception;

use Throwable;
use Exception;
use Otushw\Logger\AppLogger;

class AppException extends Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $message = $this->processMsg($message);
        AppLogger::addError($message);
    }

    public function processMsg(string $message): string
    {
        return 'AppException: ' . $message;
    }
}