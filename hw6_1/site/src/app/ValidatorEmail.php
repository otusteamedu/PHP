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
            if (preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $email)) {
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

        if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))) {
            echo "no valid dns $domain"."</br>";
        } else {
            echo "valid email and $domain"."</br>";
        }
    }
}
