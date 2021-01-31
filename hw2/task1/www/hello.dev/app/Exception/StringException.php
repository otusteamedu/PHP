<?php

namespace App\Exception;

use Throwable;

/**
 * Class StringException
 * @package App\Exception
 */
class StringException extends \Exception
{
    /**
     * StringException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}