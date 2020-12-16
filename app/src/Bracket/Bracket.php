<?php 

namespace Bracket;

class Bracket {

    public function check() 
    {
        if (self::validate()) {
            header('HTTP/1.1 200 OK');
            return;
        }

        header('HTTP/1.1 400 Bad request');
    }

    private static function validate() : bool
    {
    
        if (empty(trim($_POST['string']))) {
            return false;
        }

        if ( (substr($_POST['string'], 0, 1) == ')') || (substr($_POST['string'], -1, 1) == '(') ) {
            return false;
        }

        foreach (str_split($_POST['string']) as $value) {

            if ($value == '(') {
                $arr[] = $value;
                continue;
            }

            if ($value == ')' and (empty($arr) or array_pop($arr) != '(')) {
                return false;
            }
        }
        
        return empty($arr);
    }
}
