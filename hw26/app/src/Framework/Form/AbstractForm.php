<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Framework\Http\Request;
use App\Framework\Validator\Validator;

abstract class AbstractForm
{
    private bool   $isValid      = false;
    private string $errorMessage = '';
    private array  $validData    = [];

    public final function handleRequest(Request $request): void
    {
        foreach ($this->getRules() as $fieldName => $rules) {
            $value = $request->getPostParam($fieldName);

            if (!$this->isValid = Validator::validate($value, $rules)) {
                $this->errorMessage = sprintf(Validator::getErrorMessage(), $fieldName);

                return;
            }

            $this->validData[$fieldName] = $value;
        }

        $this->isValid = true;
    }

    abstract protected function getRules(): array;

    public final function isValid(): bool
    {
        return $this->isValid;
    }

    public final function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public final function getValidData(): array
    {
        return $this->validData;
    }
}