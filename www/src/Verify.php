<?php


class Verify
{
    public static function verifyByFilter(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function verifyByMX(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        return $res == false ||
            count($mx_records) == 0 ||
            (count($mx_records) == 1 && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"));
    }

    public static function verifyEmail(string $email):bool
    {
        return SELF::verifyByFilter($email) &&
            SELF::verifyByMX($email);
    }
}