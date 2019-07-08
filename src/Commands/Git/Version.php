<?php

namespace lexerom\Commands\Git;

class Version extends Git
{
    protected $validCommand = 'git version';

    public function getRegex(): string
    {
        return '/^(?:g[uijklo]?t)\s+v[ersio]{3,5}n/';
    }
}