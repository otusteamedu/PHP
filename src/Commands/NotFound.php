<?php

namespace lexerom\Commands;

class NotFound extends AbstractCommand
{
    protected $validCommand = 'echo';

    public function getValidCommandWithArgs(): string
    {
        return 'echo "Sorry, command can not be found"';
    }

    public function execute(): bool
    {
        return true;
    }

    public function match(): bool
    {
        return true;
    }
}