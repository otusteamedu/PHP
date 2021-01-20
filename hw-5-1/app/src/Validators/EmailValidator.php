<?php

namespace Validators;

class EmailValidator
{
    private string $email;

    private const EMAIL_CHECK_PATTERN = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';

    public function __construct(string $email)
    {
        $this->email = trim($email);
    }

    public function validate(): ValidationResult
    {
        $validationResult = new ValidationResult($this->email);

        if ($this->checkIsEmpty() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('empty');
        }
        else if ($this->checkBadPattern() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('wrong email');
        }
        else if ($this->checkBadMx() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('wrong MX');
        }
        else {
            $validationResult->setStatus('valid');
            $validationResult->setMessage('OK');
        }

        return $validationResult;
    }

    private function checkIsEmpty(): bool
    {
        return $this->email === '';
    }

    private function checkBadPattern(): bool
    {
        return !preg_match(self::EMAIL_CHECK_PATTERN, $this->email);
    }

    private function checkBadMx(): bool
    {
        $hostname = explode('@', $this->email)[1];
        return !checkdnsrr($hostname, "MX");
    }
}
