<?php

namespace EmailValidator\Validation;

class MxValidation implements ValidationInterface
{
    public function isValid(string $email): bool
    {
        $host = substr(strrchr($email, '@'), 1);

        return checkdnsrr($host, 'MX');
    }
}