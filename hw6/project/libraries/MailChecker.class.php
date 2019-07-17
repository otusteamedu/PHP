<?php
declare(strict_types=1);

class MailChecker
{
    const MAIL_PATTERN = '/^[^@]+@([^@]+)+\.[^@\.]+$/';

    public function checkMail(string $mail): bool
    {
        if (
            $this->checkWithRegularExpression($mail) === true
            && $this->checkWithDns($mail) === true
        ) {
            return true;
        }
        return false;
    }

    private function checkWithRegularExpression(string $mail): bool
    {
        return preg_match(self::MAIL_PATTERN, $mail) ? true : false;
    }

    private function checkWithDns(string $mail): bool
    {
        $domain = substr(strrchr($mail, "@"), 1);
        return getmxrr($domain, $hosts);
    }
}