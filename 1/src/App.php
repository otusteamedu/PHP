<?php

namespace Src;

class App
{
    public $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function run()
    {
        $this->handle();
    }

    private function handle() {
        $parser = new Parser();
        $result = $parser->parseList($this->list);
        Printer::printResult($result);
    }
}