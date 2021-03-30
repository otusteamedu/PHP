<?php


namespace App\Utils\Validation;


use App\Utils\Validation\Exceptions\MethodNotImplementException;


abstract class AbstractValidator implements ValidatorInterface
{
    protected array $errors = [];
    protected string $error = '';

    public function validate($value): bool
    {
        throw new MethodNotImplementException();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getError(): string
    {
        return $this->error;
    }

    protected function setError($msg)
    {
        $this->error = $msg;
    }

    protected function setErrors($key, $msg)
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
