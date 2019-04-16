<?php

namespace timga\calculator;

class Input
{
    const ACTION_INDEX = 1;
    const VALUE_A_INDEX = 2;
    const VALUE_B_INDEX = 3;
    private $argv;
    private $argc;
    private $action;
    private $valueA;
    private $valueB;

    public function __construct($argc, $argv)
    {
        $this->argc = $argc;
        $this->argv = $argv;
        $this->action = $argv[self::ACTION_INDEX] ?? 'error';
        $this->valueA = $argv[self::VALUE_A_INDEX] ?? 'error';
        $this->valueB = $argv[self::VALUE_B_INDEX] ?? 'error';
    }

    public function getArgc()
    {
        return $this->argc;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getValueA()
    {
        return $this->valueA;
    }

    public function getValueB()
    {
        return $this->valueB;
    }
}