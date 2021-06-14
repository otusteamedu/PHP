<?php

declare(strict_types=1);

namespace App\Framework\Console;

class Argument
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        $array = json_decode($this->value, true);

        return (is_array($array) ? $array : []);
    }
}