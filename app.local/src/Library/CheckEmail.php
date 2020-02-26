<?php

namespace Library;


class CheckEmail
{
    
    public function isValid(string $email): bool
    {
        $emailTrim = trim($email);
        if (empty($emailTrim)) {
            return false;
        }
        
        $patternCheckEmail = '#^[^@]+@[^@]+#';
        if (!preg_match($patternCheckEmail, $emailTrim)) {
            return false;
        }
        
        if (!$this->checkMxRecordsDomain($email)) {
            return false;
        }
        
        return true;
    }
    
    private function checkMxRecordsDomain(string $email): bool
    {
        [$null, $domain] = explode('@', $email);
        
        return getmxrr($domain, $mxRecords);
    }
}
