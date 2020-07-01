<?php

namespace Services;

use \Validations\EmailValidation;
use \Validations\DNSValidation;

class ValidationService {
    private $validation;

    public function __construct(String $type)
    {
        switch($type) {
            case 'email': 
                $this->validation = new EmailValidation();
                break;
            case 'dns_mx':
                $this->validation = new DNSValidation();
                break;
        }    
    }

    public function single(String $element) : Bool
    {
        return $this->validation->single($element);
    }
        
    public function multi(Array $elements) : Array 
    {
        return $this->validation->multi($elements);
    }
}

