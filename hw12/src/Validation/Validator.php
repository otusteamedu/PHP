<?php

namespace Validation;

class Validator
{
    const MAX_STRING_SIZE = 4096;

    public $validEmails = [];
    public $badEmails   = [];
    public $emails      = [];
    public $file;

    public function __construct($emails)
    {
        if (is_readable($emails)) {
            $this->file = @fopen($emails, "r");
        }
        $this->validateEmails();
    }

    public function __destruct()
    {
        fclose($this->file);
    }

    private function validateEmails()
    {
        while (($email = fgets($this->file, self::MAX_STRING_SIZE)) !== false) {
            $this->validateEmail($email);
        }
    }

    private function checkMx($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        $response = getmxrr($domain, $mxRecords);
        return $response ? true : false;
    }

    public function validateEmail($email)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $this->checkMx($email)) {
            $this->validEmails[] = $email;
        } else {
            $this->badEmails[] = $email;
        }
    }
}
