<?php


class CheckEmailTypeForValidate
{
    public $email;

    public function __construct()
    {
        $this->email;
    }

    public function run($email) {
        $this->emailTypeDefinition($email);
    }

    private function emailTypeDefinition($email)
    {
        $validateEmail = new ValidateEmail();
        if (is_array($email)) {
            $validateEmail->validationEmailArray($email);
        } elseif (is_string($email)) {
            $validateEmail->validateEmailString($email);
        } else {
            throw new Exception('Неизвестные данные.');
        }
    }
}