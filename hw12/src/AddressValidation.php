<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */


namespace Email;


class AddressValidation
{

    public static function isValid(string $email): bool
    {
        return self::isValidFormat($email) && self::hasValidMX($email);
    }

    private static function isValidFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private static function hasValidMX(string $email): bool
    {
        $data = explode('@', $email);
        return getmxrr($data[1], $mxRecords);
    }
}