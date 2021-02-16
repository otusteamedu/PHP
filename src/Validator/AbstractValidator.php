<?php


namespace App\Validator;


abstract class AbstractValidator implements ValidatorInterface
{
    protected array $errors = [];

    public function validate($value): bool
    {
        throw new MethodNotImplementException();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function setError($msg)
    {
        array_push($this->errors, $msg);
    }
}
