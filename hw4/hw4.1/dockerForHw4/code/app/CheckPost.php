<?php

class CheckPost
{
    public $string;

    public function __construct($post) 
    {
        $this->$string = $post['string'];
    }

    public function checkEmpty() 
    {
        if (strlen($this->$string) > 0) {
            return true;
        }else{
            throw new Exception();
        }
    }

    public function checkParentheses() 
    {
        $allString = $this->$string;
        $check = 0;
        for ($i=0; $i < strlen($allString); $i++) { 
            if ($allString[$i] == '(') {
                $check++;
            }
            if ($allString[$i] == ')') {
                $check--;
            }
            if ($check < 0) {
                throw new Exception();
            }
        }
        if ($check == 0) {
            return true;
        }else{
            throw new Exception();
        }
    }
}