<?php

namespace EmailValidator\Validation;

class EmailValidation implements ValidationInterface
{
    public function isValid(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}