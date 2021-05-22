<?php

declare(strict_types=1);

namespace App\Console;

class Console implements ConsoleInterface
{
    private const COLOR__GREEN = '32m';
    private const COLOR__RED   = '31m';

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

    public function getFirstArgument(): Argument
    {
        return $this->getArgument(1);
    }

    public function getArgument(int $argumentNumber): Argument
    {
        $value = !empty($_SERVER['argv'][$argumentNumber]) ? $_SERVER['argv'][$argumentNumber] : '';

        return new Argument($value);
    }

}