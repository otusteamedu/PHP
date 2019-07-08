<?php

namespace lexerom\Commands;

abstract class AbstractCommand implements MatchInterface, ValidCmdInterface
{
    const ANSWERS_YES = [
        'y', 'YES', 'yes', 'Yes', 'Y'
    ];

    const ANSWERS_NO = [
        'n', 'N', 'No', 'NO', 'no'
    ];

    protected $validCommand;

    /**
     * @var string
     */
    protected $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function execute(): bool
    {
        while (true) {
            fputs(STDERR, sprintf('Do you mean <%s>? (y/n) ', $this->getValidCommand()));
            $answer = trim(fgets(STDIN));
            if (in_array($answer, self::ANSWERS_YES)) {
                return true;
            } elseif (in_array($answer, self::ANSWERS_NO)) {
                return false;
            }
        }

        return false;
    }

    public function getValidCommandWithArgs(): string
    {
        return $this->getValidCommand();
    }

    public function getValidCommand(?string $args = null): string
    {
        $command = $this->validCommand;
        if ($args) {
            $command .= ' ' . $args;
        }

        return $command;
    }

    abstract public function match(): bool;
}