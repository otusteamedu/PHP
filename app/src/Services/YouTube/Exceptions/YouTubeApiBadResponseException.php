<?php


namespace App\Services\YouTube\Exceptions;


use Throwable;

class YouTubeApiBadResponseException extends \Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}