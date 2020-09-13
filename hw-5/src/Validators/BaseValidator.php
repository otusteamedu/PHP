<?php

namespace AAntonov\Validators;


use AAntonov\Validators\Contracts\ValidatorInterface;

abstract class BaseValidator implements ValidatorInterface
{
    protected $field;

    protected array $errors = [];

    /**
     * @return array
     */
    public function getErrorsMessages(): array
    {
        return $this->errors;
    }

    public function getFirstError(): string
    {
        return $this->errors[0];
    }

    public function serError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function __construct($field)
    {
        $this->field = $field;
    }

    public abstract function validate();
}
