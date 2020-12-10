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
    private function validate($brackets) : bool
    {
        if (!empty(trim($brackets['string']))) {
            $result = array_count_values(str_split($brackets['string']));
            if ( isset($result['(']) and isset($result[')']) and $result['('] === $result[')'] ) {
                return true;
            } 
        }
        
        return false;
    }
}
