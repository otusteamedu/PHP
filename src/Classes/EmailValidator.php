<?php

namespace classes;

class EmailValidator
{
    private $listEmail = [];
    private $errors = [];

    public function __construct(array $emailList)
    {
        $this->listEmail = $emailList;
    }

    /**
     * Проверяет валидность email адресов
     *
     * @return void
     */

    public function validateEmail(): void
    {
        foreach ($this->listEmail as $email) {
            if ($this->validEmail($email)) {
                $this->validMxRecord($email);
            }
        }
    }

    /**
     * Проверяем верность введенных данных
     *
     * @return boolean
     */
    private function validEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->errors[$email] = 'Не валидный email';
            return false;
        }
        return true;
    }

    /**
     * Проверяем на наличие Mx - записей
     *
     * @return boolean
     */
    private function validMxRecord($email): bool
    {
        $brakeEmail = explode('@', $email);
        $resultMx = getmxrr($brakeEmail[1], $mxRecords);
        if (($resultMx == false || count($mxRecords) == 0) ||
            (count($mxRecords) && ($mxRecords[0] == null || $mxRecords[0] == '0.0.0.0'))) {
            $this->errors[$email] = 'Email не прошел проверку на наличие MX-записей';
            return false;
        }
        return true;
    }


    /**
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}