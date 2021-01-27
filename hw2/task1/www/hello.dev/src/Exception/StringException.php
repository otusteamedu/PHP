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
    public function __construct($message = "POST['string'] - пустой или не передан", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        header('HTTP/1.1 400 Bad Request');
        die($message);
    }
}