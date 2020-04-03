<?php


namespace www\src;


class MxEmailValidator extends EmailValidator {


    public function __construct() {
    }

    public function validate($email) : bool {
        $domain = substr(strchr($email,'@'),1);
        $result = getmxrr($domain, $mx_records);
        if (false == $result || 0 == count($mx_records) ||
           (1 == count($mx_records) && ($mx_records[0] == null ||
           $mx_records[0] == "0.0.0.0" ))) {
            return false;
           }
        else
            {return true;}
    }
}