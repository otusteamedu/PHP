<?php

namespace EmailChecker;

use EmailChecker\Validator\ValidatorInterface;

class EmailChecker
{
    private $validators;

    public function addValidator(ValidatorInterface $validator): EmailChecker
    {
        $this->validators[] = $validator;
        return $this; //чтобы реализовать цепочку
    }


    public function isCorrect(string $email): bool
    {
        foreach ($this->validators as $validator) {
            $validator->validate($email);
        }
        return true;
    }
}