<?php

declare(strict_types=1);

namespace App\Framework\Console;

interface ConsoleInterface
{
    public function success($message): void;

    public function error($message): void;

    public function info($message): void;

    public function setColorFor(string $color, $text): string;

    public function readLines(): array;

    public function getFirstArgument(): Argument;

    public function getArgument(int $argumentNumber): Argument;
}