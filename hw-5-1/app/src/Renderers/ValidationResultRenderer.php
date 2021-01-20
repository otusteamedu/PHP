<?php

namespace Renderers;

use ValidationResult\ValidationResult;

/**
 * Генерирует html с результатом валидации
 *
 * Class ValidationResultRenderer
 *
 * @package Renderers
 */
class ValidationResultRenderer
{
    /**
     * @var ValidationResult
     */
    private ValidationResult $validationResult;

    /**
     * ValidationResultRenderer constructor.
     *
     * @param ValidationResult $validationResult
     */
    public function __construct (ValidationResult $validationResult)
    {
        $this->validationResult = $validationResult;
    }

    /**
     * @return string
     */
    public function render (): string
    {
        $result = '<p>Email: ' . $this->validationResult->getSubject() . '</p>';
        $result .= '<p>Status: ' . $this->validationResult->getStatus() . '</p>';
        $result .= '<p> Message: ' . $this->validationResult->getMessage() . '</p><br>';

        return $result;
    }
}
