<?php

namespace Nlazarev\Hw6\Model\Email;

class EmailValidator
{
    private $email_string = null;
    private $email_user = null;
    private $email_domain = null;
    private $email_regexp = null;

    public function __construct(?string $email_string)
    {
        $this->email_string = $email_string;
    }

    public function setEmailRegExp(string $email_regexp)
    {
        $this->email_regexp = $email_regexp;
    }

    public function getEmailRegExp(): string
    {
        return $this->email_regexp;
    }

    protected function parseEmailString(): bool
    {
        $arr = explode("@", $this->email_string);
        if (count($arr) == 2) {
            $this->email_user = $arr[0];
            $this->email_domain = $arr[1];
            return true;
        } else {
            return false;
        }
    }

    protected function checkMxDomainIsExist(): bool
    {
        $email_domain = $this->email_domain;
        if (checkdnsrr(idn_to_ascii($email_domain), "MX") //icu-dev + php_intl nedeed
         || checkdnsrr($email_domain, "MX")) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkEmailToRegExp(): bool
    {
        $email_string = $this->email_string;
        $regexp = $this->getEmailRegExp();
//        mb_regex_encoding('UTF-8');
//        if (mb_eregi($regexp, $email_string) != 1) {
        if (preg_match($regexp, $email_string) === 1) {
            return true;
        } else {
            return false;
        }
    }   

    public function validateString(bool $use_filter_var = true): bool
    {
        $email_string = $this->email_string;

        if ($use_filter_var) {
            if (filter_var($email_string, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->parseEmailString()) {
                if ($this->checkEmailToRegExp()) {
                    if ($this->checkMxDomainIsExist()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

}