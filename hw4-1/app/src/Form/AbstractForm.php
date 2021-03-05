<?php

declare(strict_types=1);

namespace App\Form;

use App\Http\Request;
use App\Validator\Validator;

abstract class AbstractForm
{

    private bool   $isValid      = false;
    private string $errorMessage = '';

    public final function handleRequest(Request $request): void
    {
        foreach ($this->getRules() as $fieldName => $rules) {
            $value = $request->getPost($fieldName);

            if (!$this->isValid = Validator::validate($value, $rules)) {
                $this->errorMessage = Validator::getErrorMessage();

                return;
            }
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

}