<?php

declare(strict_types=1);

namespace App\Framework\Console\Argument;

class StringArgument implements ArgumentInterface
{
    private string $value;

    public function __construct($argumentNameOrNumber, string $argumentValue)
    {
        $this->value = $argumentValue;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}