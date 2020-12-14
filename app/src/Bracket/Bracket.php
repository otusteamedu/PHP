<?php 

namespace Bracket;

class Bracket {

    public function check($request) 
    {
        if ($this->validate($request)) {
            header('HTTP/1.1 200 OK');
            return;
        }

        header('HTTP/1.1 400 Bad request');
    }

    //вернет тру если примет ))((
    private function validate($brakets) : bool
    {
    
        if (empty(trim($brakets['string']))) {
            return false;
        }

        if ( (substr($brakets['string'], 0, 1) == ')') || (substr($brakets['string'], -1, 1) == '(') ) {
            return false;
        }

        foreach (str_split($brakets['string']) as $value) {

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
