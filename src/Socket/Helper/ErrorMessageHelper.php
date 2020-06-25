<?php

namespace HomeWork\Socket\Helper;

class ErrorMessageHelper
{
    public static function getCreateErrorMessage(int $errCode): string
    {
        return sprintf('Can not create socket. Error: %s', socket_strerror($errCode));
    }

    public static function getBindErrorMessage(int $errCode): string
    {
        return sprintf('Can not bind socket. Error: %s', socket_strerror($errCode));
    }

    public static function getSendErrorMessage(int $errCode): string
    {
        return sprintf('Can not send socket. Error: %s', socket_strerror($errCode));
    }
}
