<?php


class ValidateEmail
{
    /**
     * @var $email ;
     */
    public $email;

    public function __construct()
    {
        $this->email;
    }

    public function emailValidations($email)
    {
        if (is_array($email)) {
            $this->validationEmailArray($email);
        } elseif (is_string($email)) {
            $this->validateEmailString($email);
        } else {
            throw new Exception('Неизвестные данные.');
        }
    }

    private function validationEmailArray(array $email): void
    {
        for ($i = 0; $i < count($email); $i++) {
            $this->validateEmailString($email[$i]);
        }
    }

    protected function validateEmailString(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validateMXRecording($email);
        } else {
            return false;
        }
    }

    protected function validateMXRecording(string $email): bool
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