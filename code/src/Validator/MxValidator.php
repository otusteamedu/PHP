<?php

namespace EmailChecker\Validator;

use EmailChecker\Exceptions\EmailIsNotExists;

class MxValidator implements ValidatorInterface
{
    public function validate(string $email)
    {
        $emailParts = explode('@', $email);
        if (!checkdnsrr(array_pop($emailParts), 'MX')) {
            throw new EmailIsNotExists("$email - не прошел проверку DNS");
        }
    }
}