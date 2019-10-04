<?php

declare(strict_types=1);

class EmailVerification
{
    public function checkEmail(string $email): bool
    {
        if ($this->checkFormat($email) && $this->checkDns($email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function checkFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false ? true : false;
    }
    private function checkDns(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return getmxrr($domain, $hosts);
    }

}