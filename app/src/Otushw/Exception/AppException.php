<?php


namespace Otushw\Exception;

use Throwable;
use Exception;
use Otushw\Logger\AppLogger;

/**
 * Class AppException
 *
 * @package Otushw\Exception
 */
class AppException extends Exception
{

    /**
     * AppException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $message = $this->processMsg($message);
        AppLogger::addError($message);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public function processMsg(string $message): string
    {
        return 'AppException: ' . $message;
    }

}