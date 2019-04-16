<?php

namespace Otus;

/**
 * Class EmailChecker
 * @package Otus
 */
class EmailChecker
{

    /**
     * validation function
     *  - checks by simple regular expression (only "@" and ".")
     *  - checks domain e-mails for MX record. getmxrr()
     *
     * @param string $email
     * @return bool
     * return false, if $email doesn't have "@" or ".", or domain doesn't have MX record
     */
    public function checkEmail(string $email): bool
    {
        if (!preg_match("/.+@.+\..+/i", $email)) {
            return false;
        }

        $domain = substr($email, strpos($email, '@') + 1);

        if (!getmxrr($domain, $mxhosts)) {
            return false;
        }

        return true;
    }

}