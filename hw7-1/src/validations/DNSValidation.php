<?php

namespace Validations;

class DNSValidation {
    private $regx = '/^(mx).([a-z].*?\.)(ru|com|net)/im';

    public function __construct() {}
    
    public function single(String $dns) : Bool
    {
        return $this->isValid($dns);
    }

    public function multi() : String {
        return 'MX отсутствует метод "multi"';
    }

    private function isValid(String $dns) : Bool
    {
        return (preg_match($this->regx, $dns))
            ? true
            : false;
    }
}

