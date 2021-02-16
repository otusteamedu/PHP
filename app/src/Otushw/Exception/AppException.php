<?php


namespace Otushw\Exception;

use Monolog\Logger;
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
     * @var LoggerFactory
     */
    protected LoggerFactory $log;

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
        AppLogger::addError($message);
    }

}