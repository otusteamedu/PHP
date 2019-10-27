<?php

namespace App\EmailValidators;

use App\Contracts\EmailValidatorContract;

class SyntaxValidator implements EmailValidatorContract
{
    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
