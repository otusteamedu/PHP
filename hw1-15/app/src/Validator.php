<?php
namespace Src;

class Validator
{
    /**
     * @throws \Exception
     */
    public static function validate(array $params)
    {
        if (empty($params['email'])) {
            throw new \Exception('Please, fill your email', 400);
        }

        if (!self::isValid($params['email'])) {
            throw new \Exception('Your email is not valid. Please, check email', 400);
        }
    }

    private static function isValid($email): bool
    {
        return self::isStringEmail($email) && self::isEmailValidMx($email) && self::isRegexpValid($email);
    }

    /**
     * @param $string
     *
     * @return bool
     */
    private static function isStringEmail($string): bool
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $email
     *
     * @return bool
     */
    private static function isRegexpValid($email): bool
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        return preg_match($regex, $email) === 1;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    private static function isEmailValidMx($email): bool
    {
        $email_host = strtolower(substr(strrchr($email, "@"), 1));
        return checkdnsrr($email_host, "MX");
    }
}