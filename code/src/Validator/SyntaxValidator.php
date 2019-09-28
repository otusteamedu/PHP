<?php

namespace EmailChecker\Validator;

use EmailChecker\Exceptions\EmailSyntaxIsNotValid;

class SyntaxValidator implements ValidatorInterface
{
    public function validate(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailSyntaxIsNotValid("$email - не прошел синтаксическую проверку");
        }
    }
}