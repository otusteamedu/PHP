<?php

namespace Classes\Email\Validator;

class RegExpEmailValidator implements EmailValidator
{
    private $error;

    public function isValid(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = sprintf('%s не является валидным email -ом', $email);
            return false;
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->error;
    }
}
