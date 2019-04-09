<?php

namespace crazydope\validation;

abstract class AbstractValidator
    implements ValidatorInterface
{
    protected $errors = [];

    protected function addError( string $message): void
    {
        $this->errors[] = $message;
    }

    abstract public function isValid( $value ): bool;

    public function __invoke($value)
    {
        return $this->isValid($value);
    }

    public function getErrors(): string
    {
        if(empty($this->errors)) {
            return '';
        }

        return implode("\n", $this->errors);
    }
}