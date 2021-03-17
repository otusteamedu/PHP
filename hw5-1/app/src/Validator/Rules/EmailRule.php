<?php

declare(strict_types=1);

namespace App\Validator\Rules;

class EmailRule implements RuleInterface
{

    public function validate($value): bool
    {
        return $this->isEmailValid($value);
    }

    private function isEmailValid(string $email): bool
    {
        $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

        return !!preg_match($pattern, $email);
    }

    public function getErrorMessage(): string
    {
        return 'Указан некорректный адрес электронной почты';
    }

}