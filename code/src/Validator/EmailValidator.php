<?php


namespace App\Validator;


class EmailValidator extends AbstractValidator
{
    const EMAIL_REGEX = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/ ';

    public function validate($value): bool
    {
        if (!preg_match(self::EMAIL_REGEX, $value)) {
            $this->setError($value,'Invalid email address');
            return false;
        }

//        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
//            $this->setError($value,'Invalid email address');
//            return false;
//        }

        list(, $domain) = explode('@', $value);

        if (!checkdnsrr($domain, 'MX')) {
            $this->setError($value,'Domain in not valid');
            return false;
        }

        return true;
    }

    public function validateAll(array $values): bool
    {
        $state = true;

        foreach ($values as $value) {
            $state = $this->validate($value);
        }

        return $state;
    }
}
