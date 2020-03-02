<?php

namespace App\EmailValidator;

abstract class EmailValidation
{
    protected string $error = '';

    abstract public function isValid(string $email): bool;

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }
}
