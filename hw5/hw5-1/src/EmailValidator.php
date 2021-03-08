<?php


namespace Src;


class EmailValidator
{
    private $email;
    private $emailPattern = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';

    public function __construct($email)
    {
        $this->email = trim($email);
    }

    public function isEmailValid(): bool
    {
        return $this->isNotEmpty() && $this->isPatternValid() && $this->isMXValid();
    }

    private function isMXValid(): bool
    {
        $exploded = explode('@', $this->email);
        $hostName = $exploded[1] ?? '';

        return $hostName !== '' && checkdnsrr($hostName);
    }

    private function isPatternValid(): bool
    {
        return preg_match($this->emailPattern, $this->email);
    }

    private function isNotEmpty():bool
    {
        return strlen(trim($this->email)) > 0;
    }
}