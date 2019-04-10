<?php

namespace crazydope\validation;

abstract class AbstractValidator
    implements ValidatorInterface
{
    protected $errors = [];

    protected function addError( string $message ): void
    {
        $this->errors[] = $message;
    }

    abstract public function isValid( $value ): bool;

    public function getErrors(): array
    {
        return $this->errors;
    }
}