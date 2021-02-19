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

    protected function setError($key, $msg)
    {
        if (! array_key_exists($key, $this->errors)) {
            $this->errors[$key] = [];
        }

        array_push($this->errors[$key], $msg);
    }

    public function clear()
    {
        $this->errors = [];
    }

}
