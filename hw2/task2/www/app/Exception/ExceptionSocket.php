<?php

namespace App2\Exception;

use Throwable;

/**
 * Class ExceptionSocket
 * @package App2\Exception
 */
class ExceptionSocket extends \Exception
{
    /**
     * ExceptionSocket constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}