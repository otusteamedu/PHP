<?php

declare(strict_types=1);

namespace App\Validator;

class MinLengthValidator
{

    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function validate(string $value): bool
    {
        return (strlen($value) >= $this->length);
    }

}