<?php

namespace Ushakov\EmailValidator\Rules;

/**
 * Class MXCheckRule
 * Проверка email по существованию mx записи в dns сервера
 *
 * @package Ushakov\EmailValidator\Rules
 */
class MXCheckRule extends AbstractRule
{
    public static function validate(string $email): bool
    {
        $emailArray = explode("@", $email);
        if (count($emailArray) !== 2) {
            return false;
        }
        $host = $emailArray[1];
        $mxExists = getmxrr($host, $mxHosts);

        // Проверяю, что MX запись есть, и что для этой записи есть в соответсвии адреса для отправки
        return $mxExists === true && !empty($mxHosts);
    }
}
