<?php

namespace App;


abstract class AbstractEmailValidator implements EmailValidatorInterface
{
    private EmailValidatorInterface $nextValidator;

    public function setNext(EmailValidatorInterface $validator): EmailValidatorInterface
    {
        $this->nextValidator = $validator;

        return $validator;
    }

    public function validate(string $email): void
    {
        if ($this->nextValidator ?? null) {
            $this->nextValidator->validate($email);
        }
    }
}