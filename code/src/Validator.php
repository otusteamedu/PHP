<?php
namespace code\src;
class Validator {
    private  $string;

    public function __construct($string) {
        $this->string = $string;
    }
    public function validate () : bool {
        $counter = 0;
        $arr = str_split($this->string);
        foreach ($arr as $value) {
            if ($counter < 0) {return false;}
            if ($value == "(") {
                $counter+=1;
            }
            else {
                $counter-=1;
            }
        }
        return $counter == 0;
    }
}