<?php

namespace lexerom\Commands\Git;

class Commit extends Git
{
    protected $validCommand = 'git commit';

    public function getRegex(): string
    {
        return '/^(?:g[uijklo]?t)\s+c[cmoaipu]?m{1,2}[ie]?t(?:\s{0,}(.*?))?$/';
    }
}