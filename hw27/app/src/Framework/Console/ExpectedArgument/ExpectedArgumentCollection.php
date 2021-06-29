<?php

declare(strict_types=1);

namespace App\Framework\Console\ExpectedArgument;

use UnexpectedValueException;

class ExpectedArgumentCollection
{
    private array $arguments   = [];
    private array $mapByNumber = [];

    public function add(ExpectedArgument $expectedArgument): void
    {
        $argumentNumber = count($this->arguments) + 1;
        $expectedArgument->setNumber($argumentNumber);

        $this->arguments[$expectedArgument->getName()] = $expectedArgument;
        $this->mapByNumber[$argumentNumber] = $expectedArgument->getName();
    }

    public function get(string $argumentName): ExpectedArgument
    {
        if (empty($this->arguments[$argumentName])) {
            throw new UnexpectedValueException("Аргумент $argumentName не объявлен");
        }

        return $this->arguments[$argumentName];
    }

    public function findByNumber(int $argumentNumber): ?ExpectedArgument
    {
        if (empty($this->mapByNumber[$argumentNumber])) {
            return null;
        }

        return $this->arguments[$this->mapByNumber[$argumentNumber]];
    }
}