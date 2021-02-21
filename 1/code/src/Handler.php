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
        $this->handleString();
    }

    private function handleString() {
        $parser = new Parser($this->string);
        $result = $parser->parse();
        Printer::printResult($result);
    }
}