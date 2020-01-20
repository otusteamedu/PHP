<?php

/**
 * Class EmailValidator
 * Валидатор для проверки email адреса по 2м параметрам:
 *  - по соответсивию regex
 *  - по существованию mx записи в dns сервера
 */
class EmailValidator
{

    private static function validateWithRegex(string $emailString): bool
    {
        return filter_var($emailString, FILTER_VALIDATE_EMAIL) !== false;
    }

    private static function validateWithMXRecord(string $emailString): bool
    {
        $emailArray = explode("@", $emailString);
        if (count($emailArray) !== 2) {
            return false;
        }
        $host = $emailArray[1];
        $mxExists = getmxrr($host, $mxHosts);

        // Проверяю, что MX запись есть, и что для этой записи есть в соответсвии адреса для отправки
        return $mxExists === true && !empty($mxHosts);
    }

    public static function validate(string $emailString)
    {
        return static::validateWithRegex($emailString) && static::validateWithMXRecord($emailString);
    }
}
