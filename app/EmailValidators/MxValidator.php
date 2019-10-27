<?php

namespace App\EmailValidators;

use App\Contracts\EmailValidatorContract;
use Exception;

class MxValidator implements EmailValidatorContract
{
    private function extractHost($email)
    {
        return explode('@', $email)[1];
    }

    public function isValidEmail(string $email): bool
    {
        try {
            return checkdnsrr($this->extractHost($email), 'MX');
        } catch (Exception $e) {
            return false;
        }
    }
}
