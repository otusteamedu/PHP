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
        $parser = new Parser();
        $result = $parser->parseList($this->list);
        if (!empty($result)) {
            echo 'Validated emails list: ' . PHP_EOL;
            foreach ($result as $email) {
                echo $email;
            }
        } else {
            echo 'No valid email found';
        }
    }
}