<?php

namespace App;

class EmailValidator
{
    public function check(string $email): bool
    {
        $validators = app()->tagged('emailsValidators');

        foreach ($validators as $validator) {
            $isValidEmail = $validator->isValidEmail($email);

            if (!$isValidEmail) {
                return false;
            }
        }

        return true;
    }
}
