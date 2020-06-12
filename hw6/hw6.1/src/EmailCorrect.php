<?php


namespace Email;


class EmailCorrect
{
    protected string $email = "exam@example.com";
    protected string $domain;

    // используйте для валидации регулярным выражением
    protected const FLAG_OPERATION_PREG = 0;

    // используйте для валидации функцией filter_var(), выборан по умолчанию
    protected const FLAG_OPERATION_FUNC = 1;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->domain = substr($this->email, strpos($this->email, '@') + 1);
    }

    public function validateEmail(int $flag = self::FLAG_OPERATION_FUNC): bool
    {
        $operation = $flag ?
            filter_var($this->email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE) :
            preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $this->email);
        if ($operation && getmxrr($this->domain, $mx_records, $mx_weight)) {
            return true;
        } else {
            return false;
        }
    }
}
