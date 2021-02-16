<?php


namespace App\Validator;


class EmailValidator extends AbstractValidator
{
    public function validate($value): bool
    {
        $this->errors = [];

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setError('Invalid email address');
            return false;
        }

        list(, $domain) = explode('@', $value);

        if (!checkdnsrr($domain, 'MX')) {
            $this->setError('Domain in not valid');
            return false;
        }

        return true;
    }
}
