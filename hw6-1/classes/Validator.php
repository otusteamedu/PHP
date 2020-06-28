<?php

namespace Classes;

class Validator {
    private $reg = "#^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$#";

    public function __construct() {}

    public function isCorrect (String $string) : Bool {
        return (preg_match($this->reg, $string)) 
            ? true
            : false;
    }
}
