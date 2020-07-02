<?php

namespace Services;

use \Validations\EmailValidation;
use \Validations\DNSValidation;

class ValidationService {
    private $validation;

    public function __construct(String $type) {
        $this->setValidation($type);
    }

    public function method(String $method, $element) 
    {
        if (gettype($element) != 'string' && gettype($element) != 'array') {
            echo 'Тип должен быть string или array line ' . __LINE__ . ': ' . __FILE__ . "\n";

            die;
        }

        return $this->validation->$method($element);
    }

    private function setValidation(String $type)
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

