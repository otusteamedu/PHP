<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Framework\Console\Argument\ArgumentInterface;
use App\Framework\Console\Argument\Arguments;
use App\Framework\Console\ExpectedArgument\ExpectedArgument;
use Exception;

class Console implements ConsoleInterface
{
    private const COLOR__GREEN = '32m';
    private const COLOR__RED   = '31m';
    private Arguments $arguments;

    public function __construct(Arguments $arguments)
    {
        $this->arguments = $arguments;
    }

    public function success($message): void
    {
        $message = $this->setColorFor(self::COLOR__GREEN, $message);

        $this->writeLn($message);
    }

    public function error($message): void
    {
        $message = $this->setColorFor(self::COLOR__RED, $message);

        $this->writeLn($message);
    }

    public function info($message): void
    {
        $this->writeLn($message);
    }

    public function setColorFor(string $color, $text): string
    {
        return "\033[$color$text\033[0m";
    }

    private function writeLn($message): void
    {
        $this->write($message . PHP_EOL);
    }

    private function write($message): void
    {
        echo $message;
    }

    public function readLines(): array
    {
        stream_set_blocking(STDIN, false);

        $data = [];

        while (!feof(STDIN)) {
            if (false === $value = fgets(STDIN)) {
                break;
            }
            $data[] = rtrim($value);
        }

        return $data;
    }

    public function addExpectedArgument(ExpectedArgument $expectedArgument): void
    {
        $this->arguments->addExpectedArgument($expectedArgument);
    }

    /**
     * @throws Exception
     */
    public function getFirstArgument(): ArgumentInterface
    {
        return $this->arguments->getFirst();
    }

    /**
     * @throws Exception
     */
    public function getArgumentByNumber(int $argumentNumber): ArgumentInterface
    {
        return $this->arguments->getByNumber($argumentNumber);
    }

    /**
     * @throws Exception
     */
    public function getArgumentByName(string $argumentName): ArgumentInterface
    {
        return $this->arguments->getByName($argumentName);
    }

}