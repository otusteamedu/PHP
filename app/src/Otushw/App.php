<?php

namespace Otushw;

class App
{
    private string $msg;

    public function __construct()
    {
        $this->msg = 'Hello! I am test deploy';
    }

    public function run()
    {
        echo $this->msg;
    }
}

