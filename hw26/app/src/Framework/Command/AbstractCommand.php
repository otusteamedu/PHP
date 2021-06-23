<?php

declare(strict_types=1);

namespace App\Framework\Command;

use App\Framework\Console\ConsoleInterface;
use App\Framework\Console\ExpectedArgument\ExpectedArgument;

abstract class AbstractCommand implements CommandInterface
{
    protected ConsoleInterface $console;

    final public function run(ConsoleInterface $console): void
    {
        $this->console = $console;

        $this->fillExpectedArguments();

        $this->execute();
    }

    abstract protected function execute(): void;

    abstract protected function fillExpectedArguments(): void;

    protected function addExpectedArgument(string $name, int $type, array $rules = []): void
    {
        $this->console->addExpectedArgument(new ExpectedArgument($name, $type, $rules));
    }
}