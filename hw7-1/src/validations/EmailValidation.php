<?php

namespace Validations;

class EmailValidation {
    private $regx = '/[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/im';

    public function __construct() {}

    public function single(String $email) : Bool
    {
        return $this->isValid($email);
    }

    public function multi(Array $emails) : Array
    {
        $result = [];

        foreach($emails AS $email) {
            $result[] = [
                'email' => $email,
                'valid' => $this->isValid($email)
            ];    
        }           

        return $result;
    }

    private function isValid(String $email) : Bool
    {
        return (preg_match($this->regx, $email))
            ? true
            : false;
    }
}

