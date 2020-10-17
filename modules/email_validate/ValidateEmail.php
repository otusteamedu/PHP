<?php


class ValidateEmail
{
    protected $email;

    public function __construct()
    {
        $this->emaill;
    }

    public function validationEmailArray(array $email): void
    {
        $i = 0;
        do {
            $this->validateEmailString($email[$i]);
            $i++;
        } while ($i <= count($email));
    }

    public function validateEmailString(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validateMXRecording($email);
        } else {
            return false;
        }
    }

    public function validateMXRecording(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (false == $res
            || 0 == count($mx_records)
            || (1 == count($mx_records)
                && ($mx_records[0] == null
                    || $mx_records[0] == "0.0.0.0"))) {
            return false;
        } else {
            return true;
        }
    }

}