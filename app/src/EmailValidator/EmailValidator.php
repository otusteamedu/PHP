<?php

namespace EmailValidator;

class EmailValidator {
    
    public function run($request = [])
    {
        if (empty($request['emails']) and !is_array($request['emails'])) {
            throw new \Exception('something wrong with emails');
        } 
        
        foreach($request['emails'] as $email) {
            if (!$this->validEmail($email,true)){
                echo "$email is not a valid" . "\n";
            } else {
                echo "$email is a valid" . "\n";
            }
        }
    }

    private function validEmail(string $email, $extended = false)
    {
        if (empty($email)) {
            return false;
        }

        if (!preg_match('/^([a-z0-9_\'&\\.\\-\\+])+\\@(([a-z0-9\\-])+\\.)+([a-z0-9]{2,10})+$/i', $email)) {
            return false;
        }

        $domain = substr($email, strrpos($email, '@') + 1);
        $mxhosts = [];
        $checkDomain = getmxrr($domain, $mxhosts);

        if (!$checkDomain || empty($mxhosts)) {
            $dns = dns_get_record($domain, DNS_A);
            if (empty($dns)) {
                return false;
            }
        }

        return true;
    }
}