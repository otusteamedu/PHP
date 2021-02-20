<?php

namespace Src;

class Handler
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function run()
    {
        $parser = new Parser($this->string);
        $parser->parse();
    }
}