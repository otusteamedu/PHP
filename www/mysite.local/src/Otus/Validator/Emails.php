<?php

namespace Otus\Validator;

class Emails
{
    const MAX_STRING_SIZE = 4096;
    
    public $validEmails = [];
    public $badEmails = [];
    public $emails = [];
    public $handle = false;
    
    public function __construct($emails)
    {
        if (is_array($emails)) {
            $this->emails = $emails;
        } else if(is_readable($emails)) {
            $this->handle = @fopen($emails, "r");
        }
    }
    
    public function __destruct() {
        if ($this->handle) {
            fclose($this->handle);
        }
    }
    
    public function getValidEmails()
    {
        if ($this->handle) {
            return $this->validateFileEmails();
        } else {
            return $this->validateArrayEmails();
        }
    }
    
    private function validateFileEmails()
    {
        while (($email = fgets($this->handle, self::MAX_STRING_SIZE)) !== false) {
            if ($email = $this->validateEmail($email)) {
                $this->validEmails[] = $this->validateEmail($email);
            }
        }
        $this->validEmails = array_unique($this->validEmails);
        return $this->validEmails;
    }
    
    private function validateArrayEmails()
    {
        foreach ($this->emails as $email) {
            if ($email = $this->validateEmail($email)) {
                $this->validEmails[] = $this->validateEmail($email);
            }
        }
        $this->validEmails = array_unique($this->validEmails);
        return $this->validEmails;
    }
    
    private function checkMx($domain)
    {
        $response = getmxrr($domain, $mxRecords);
        if ($response != false && count($mxRecords) > 0) {
            return true;
        }
        return false;
    }
    
    public function validateEmail($email)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain = substr(strrchr($email, "@"), 1);
            if ($this->checkMx($domain)) {
                return $email;
            }
        }
        $this->badEmails[] = $email;
    }
}