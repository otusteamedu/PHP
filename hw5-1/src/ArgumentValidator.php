<?php

namespace timga\calculator;

class ArgumentValidator
{
    private $argc;
    private $argv;
    private static $allowedActions = ["add","subtract"];

    public function __construct($argc, $argv)
    {
        $this->argc = $argc;
        $this->argv = $argv;
        if (!self::checkNumOfArguments($argc)) {
            die("Error: incorrect number of arguments!");
        }
    }

    public function getAction($index): string
    {
        $action = $this->argv[$index] ?? "error";
        if (in_array($action, self::$allowedActions)) {
            return $action;
        }
        die("Error: incorrect action!");
    }

    public function getValue($index): float
    {
        $value = $this->argv[$index];
        if (is_numeric($value)) {
            return $value;
        }
        die("Error: incorrect value!");
    }

    private static function checkNumOfArguments($argc): bool
    {
        return ($argc == 4);
    }
}