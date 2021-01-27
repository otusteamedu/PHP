<?php


namespace App\Exception;


use Throwable;

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
        $message = "Строка не корректна count: $message";
        parent::__construct($message, $code, $previous);
        header('HTTP/1.1 400 Bad Request');
        die($message);
    }
}