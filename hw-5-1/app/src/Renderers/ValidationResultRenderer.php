<?php

namespace Renderers;

use Validators\ValidationResult;

class ValidationResultRenderer
{
    private ValidationResult $validationResult;

    public function __construct(ValidationResult $validationResult)
    {
        $this->validationResult = $validationResult;
    }

    public function render(): string
    {
        $result = '<p>Email: ' . $this->validationResult->getSubject() . '</p>';
        $result .= '<p>Status: ' . $this->validationResult->getStatus() . '</p>';
        $result .= '<p> Message: ' . $this->validationResult->getMessage() . '</p><br>';

        return $result;
    }
}
