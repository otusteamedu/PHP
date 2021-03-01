<?php

declare(strict_types=1);

namespace App\Form;

use App\Http\Request;
use App\Validator\MinLengthValidator;
use App\Validator\NotEmptyValidator;
use App\Validator\NumberOfParenthesesValidator;
use App\Validator\ParenthesesRequiredValidator;
use App\Validator\ParenthesesSequenceValidator;

class StringForm
{

    private bool   $isValid;
    private string $errorMessage;
    private string $fieldName = 'string';

    public function handleRequest(Request $request): void
    {
        $value = $request->getPost($this->fieldName);

        if (!$this->isValid = (new NotEmptyValidator())->validate($value)) {
            $this->errorMessage = "Параметр {$this->fieldName} обязателен для заполнения";
        } elseif (!$this->isValid = (new MinLengthValidator($logicalMinLength = 2))->validate($value)) {
            $this->errorMessage = "Длина параметра {$this->fieldName} должна быть не менее {$logicalMinLength} символов";
        } elseif (!$this->isValid = (new ParenthesesRequiredValidator())->validate($value)) {
            $this->errorMessage = "Параметр {$this->fieldName} должен содержать символы круглых скобок";
        } elseif (!$this->isValid = (new NumberOfParenthesesValidator())->validate($value)) {
            $this->errorMessage = 'Количество открытых и закрытых скобок не совпадает';
        } elseif (!$this->isValid = (new ParenthesesSequenceValidator())->validate($value)) {
            $this->errorMessage = 'Некорректная последовательность скобок. Каждая открывающая скобка должна имеет соответствующую закрывающую скобку';
        } else {
            $this->errorMessage = '';
        }
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

}