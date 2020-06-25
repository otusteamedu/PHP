<?php

namespace HomeWork\Helper;

use HomeWork\Socket\Exception\SocketException;
use Throwable;

class MessageHelper
{
    public static function getSocketExceptionMessage(SocketException $socketException): string
    {
        return sprintf('Error in socket\'s service. ' . PHP_EOL . '%s', $socketException->getMessage());
    }

    public static function getUndefinedExceptionMessage(Throwable $exception): string
    {
        return sprintf('Oops ! Unknown error: %s', $exception->getMessage());
    }
}
