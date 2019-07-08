<?php

namespace lexerom\Commands\Git;

use lexerom\Commands\AbstractRegexCommand;
use lexerom\Commands\GroupInterface;

class Git extends AbstractRegexCommand implements GroupInterface
{
    protected $validCommand = 'git';

    public function getRegex(): string
    {
        return '/^(?:g[uijklo]?t)\s+/';
    }

    public function getCommands(): array
    {
        return [
            'commit' => 'lexerom\Commands\Git\Commit',
            'version' => 'lexerom\Commands\Git\Version'
        ];
    }
}