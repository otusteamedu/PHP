<?php

namespace App\Exception;

use Throwable;

/**
 * Class ValidateStringException
 * @package App\Exception
 */
class ValidateStringException extends \Exception
{
    /**
     * ValidateStringException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}