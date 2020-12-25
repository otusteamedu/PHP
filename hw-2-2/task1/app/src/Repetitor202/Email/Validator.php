<?php


namespace Repetitor202\Email;


class Validator
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public final function validateEmail(string $email): bool
    {
        $templateEmail = '/^[a-z0-9-.+_]+@[a-z0-9-.+_]+.[a-z]{2,4}$/i';

        return preg_match($templateEmail, $email);
    }

    /**
     * @param string $hostname
     *
     * @return bool
     */
    public final function validateHostname(string $hostname): bool
    {
        $hosts = [];

        return getmxrr($hostname, $hosts);
    }
}