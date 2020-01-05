<?php

namespace AI\backend_php_hw5_1\Input;


class CommandLine extends Input
{
    public function __construct()
    {
        $this->params = [];

        for ($i = 1; $i < $_SERVER['argc']; $i++) {
            $argue = explode('=', $_SERVER['argv'][$i]);
            $this->params[$argue[0]] = $argue[1] ?? '';
        }
    }
}