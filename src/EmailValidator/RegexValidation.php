<?php

namespace App\EmailValidator;

class RegexValidation extends EmailValidation
{
    /**
     * Здесь не охватываются все случаи, но будем считать, что в рамках задачи этого достаточно
     * @see https://emailregex.com/
     */
    protected const PATTERN = '/^[a-z0-9_.+-]+@[a-z0-9-]+\.[a-z0-9-.]+$/i';

    public function isValid(string $email): bool
    {
        $result = preg_match(static::PATTERN, $email);
        if (!$result) {
            $this->setError('This email not match regex pattern');
        }
        return $result;
    }
}
