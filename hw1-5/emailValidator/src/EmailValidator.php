<?php

namespace Src;

/**
 * Class EmailValidator
 *
 * @package Src
 */
class EmailValidator
{
    /**
     * @var string $email
     */
    private string $email;

    /**
     * EmailValidator constructor.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function isValid(): bool
    {
        return $this->isStringEmail($this->email) && $this->isEmailValidMx($this->email) && $this->isRegexpValid($this->email);
    }

    /**
     * @param $string
     *
     * @return bool
     */
    public function isStringEmail($string): bool
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function isRegexpValid($email): bool
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        return preg_match($regex, $email) === 1;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function isEmailValidMx($email): bool
    {
        $email_host = strtolower(substr(strrchr($email, "@"), 1));
        return checkdnsrr($email_host, "MX");
    }
}