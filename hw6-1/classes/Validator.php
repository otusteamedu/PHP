<?php

namespace Classes;

class Validator {
    private $brackets = [
        ['{', '}'],
        ['(', ')'],
        ['[', ']']
    ];

    public function __construct() {}

    public function isCorrect (String $string) : Bool {
        $string = trim($string);

        foreach($this->brackets AS $bracket){
            if( substr_count($string, $bracket[0]) != substr_count($string, $bracket[1]) )
                return false;
        }
        
        return true;
    }
}
