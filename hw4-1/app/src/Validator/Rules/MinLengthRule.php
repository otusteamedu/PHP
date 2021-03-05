<?php

declare(strict_types=1);

namespace App\Validator\Rules;

use InvalidArgumentException;

class MinLengthRule implements RuleInterface
{

    private int $length;

    public function __construct($length = null)
    {
        if (!is_numeric($length)) {
            throw new InvalidArgumentException('Параметр length должен быть числом');
        }

        $this->length = (int) $length;
    }

    public function validate($value): bool
    {
        return (strlen($value) >= $this->length);
    }

    public function getErrorMessage(): string
    {
        return "Длина должна быть не менее {$this->length} символов";
    }

}