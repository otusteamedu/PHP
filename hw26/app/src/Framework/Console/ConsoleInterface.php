<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Framework\Console\Argument\ArgumentInterface;
use App\Framework\Console\ExpectedArgument\ExpectedArgument;

interface ConsoleInterface
{
    public function success($message): void;

    public function error($message): void;

    public function info($message): void;

    public function setColorFor(string $color, $text): string;

    public function readLines(): array;

    public function addExpectedArgument(ExpectedArgument $expectedArgument): void;

    public function getFirstArgument(): ArgumentInterface;

    public function getArgumentByNumber(int $argumentNumber): ArgumentInterface;

    public function getArgumentByName(string $argumentName): ArgumentInterface;
}