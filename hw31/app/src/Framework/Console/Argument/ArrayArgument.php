<?php

declare(strict_types=1);

namespace App\Framework\Console\Argument;

use InvalidArgumentException;

class ArrayArgument implements ArgumentInterface
{
    private array $value;

    public function __construct($argumentNameOrNumber, string $argumentValue)
    {
        $array = json_decode($argumentValue, true);

        if (!is_array($array)) {
            throw new InvalidArgumentException("Аргумент $argumentNameOrNumber должен содержать массив");
        }

        $this->value = $array;
    }

    public function getValue(): array
    {
        return $this->value;
    }
}