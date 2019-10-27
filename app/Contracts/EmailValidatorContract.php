<?php

namespace App\Contracts;

interface EmailValidatorContract
{
    public function isValidEmail(string $email): bool;
}
