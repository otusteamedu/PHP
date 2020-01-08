<?php

namespace App\Validator;

class EmailValidator
{
    protected $errors = [];

    /**
     * Проверяем верность введенных данных
     *
     * @param array $emails
     * @return array
     */
    public function isValid(array $emails): string
    {
        $this->errors = [];
        foreach ($emails as $email) {
            $this->validate($email);
        }

        return $this->getAnswer();
    }

    protected function getAnswer()
    {
        if ($this->errors) {
            $errorMessage = '';
            foreach ($this->errors as $email => $error) {
                $errorMessage .= '"'.$email.'": '.$error.'<br/>';
            }
            return 'Ошибки: '.$errorMessage;
        }

        return 'OK';
    }

    /**
     * @param string $email
     */
    public function validate(string $email)
    {
        if ($this->validateEmailFormat($email)) {
            $this->validateMxRecord($email);
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    protected function validateEmailFormat(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->errors[$email] = 'Email не прошел проверку на корректность формата';
            return false;
        }
        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    protected function validateMxRecord($email): bool
    {
        $brakeEmail = explode('@', $email);
        $resultMx = getmxrr($brakeEmail[1], $mxRecords);
        if (($resultMx == false) || (count($mxRecords)==1 && ($mxRecords[0] == null || $mxRecords[0] == '0.0.0.0'))) {
            $this->errors[$email] = 'Email не прошел проверку на наличие MX-записей';
            return false;
        }
        return true;
    }
}