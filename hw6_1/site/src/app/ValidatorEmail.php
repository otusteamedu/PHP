<?php

namespace App;

class ValidatorEmail
{
    public function validate($emails){

        $this->validateReg($emails);
    }




    public function validateReg($emails)
    {
        foreach ($emails as $key => $email) {
            if (preg_match("/^.+@.+\..+$/", $email)) {
                $this->validateDns($email);
            } else {

                echo "non-correct email  $email"."</br>";
            }
        }
    }
    public function validateDns($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);

        if ( !$res || !count($mx_records) || (count($mx_records)==1 && (!$mx_records[0] || $mx_records[0] == "0.0.0.0"))) {
            echo "no valid dns $domain"."</br>";
        } else {
            echo "valid email and $domain"."</br>";
        }
    }
}
