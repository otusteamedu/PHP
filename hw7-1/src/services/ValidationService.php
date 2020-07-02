<?php

namespace Services;

use \Validations\EmailValidation;
use \Validations\DNSValidation;

class ValidationService {
    public $validation;

    public function __construct(String $type)
    {
       return $this->setValidation($type);
    }

    public function setValidation(String $type)
    {
        switch($type) {
            case 'email': 
                $this->validation = new EmailValidation();
                break;
            case 'dns_mx':
                $this->validation = new DNSValidation();
                break;
        }

        return $this->validation;    
    }
}

