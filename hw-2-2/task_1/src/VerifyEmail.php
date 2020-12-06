<?php
declare(strict_types=1);

namespace Verify;

class VerifyEmail
{
    private $email;
    private $errors = [];

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function verifyEmail(): bool
    {
        return $this->checkReguralExpresion() && $this->checkDNSMx();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function checkReguralExpresion(): bool
    {
        if (!preg_match("/^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}$/", $this->email)) {
            $this->errors[]='regex failed';
            return false;
        } else {
            return true;
        }
    }

    private function checkDNSMx(): bool
    {
        $mail_list=[];
        $email_explode = explode('@',$this->email);
        if (sizeof($email_explode)) {
            if (getmxrr($email_explode[1],$mail_list)) {
                return true;
            } else {
                $this->errors[]='check MX failed';
                return false;
            }
        }

    }

}