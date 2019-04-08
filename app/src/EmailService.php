<?php

namespace App;

/**
 * Class EmailService
 * @package App
 */
class EmailService
{
    /**
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        if (!$this->isValidEmail($email)) {
            return false;
        }

        if (!$this->isValidEmailDomain($email)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function isValidEmail(string $email): bool
    {
        $regExp = '/^[0-9a-z-\.]+\@[0-9a-z-]{2,}\.[a-z]{2,}$/i';

        if (!preg_match($regExp, $email)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function isValidEmailDomain(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mxRecords, $mxWeight);
        if (
            $res === false ||
            count($mxRecords) === 0 ||
            (count($mxRecords) === 1 && ($mxRecords[0] === null || $mxRecords[0] === '0.0.0.0'))
        ) {
            return false;
        }

        return true;
    }
}
