<?php

namespace lexerom\Commands;

abstract class AbstractRegexCommand extends AbstractCommand
{
    protected $args = '';

    abstract protected function getRegex(): string;

    public function match(): bool
    {
        $result = preg_match($this->getRegex(), $this->command, $this->matches);
        $this->args = $this->matches[1] ?? '';
        return $result === 1;
    }

    public function getValidCommandWithArgs(): string
    {
        return $this->getValidCommand($this->args);
    }
}