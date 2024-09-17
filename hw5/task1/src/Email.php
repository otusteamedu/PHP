<?php
/**
* Class for simple email validation
*
* @author Evgeny Prokhorov <contact@jekys.ru>
*/
namespace Jekys;

class Email
{
    /**
    * Validates e-mail address against the syntax in RFC 822
    *
    * @param string $email
    *
    * @return boolean
    */
    public static function isValid(String $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
    * Checks MX records corresponding to a given $email
    *
    * @param string $email
    *
    * @return boolean
    */
    public static function hasMX(String $email)
    {
        list($username, $domain) = explode('@', $email);

        return getmxrr($domain, $mxRecords);
    }

    /**
    * Validates email and checks domain MX
    *
    * @param string $email
    *
    * @return boolean
    */
    public static function check(String $email)
    {
        return self::isValid($email) && self::hasMX($email);
    }
}
