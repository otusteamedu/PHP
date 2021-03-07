<?php

namespace Src;


class Validator
{
    private $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function validateBrackets(): bool
    {
        return $this->isStringNotEmpty() && $this->isBracketsEqual();
    }

    private function isStringNotEmpty(): bool
    {
        return strlen(trim($this->string)) > 0;
    }

    private function isBracketsEqual(): bool
    {
        $openedBrackets = substr_count($this->string, '(');
        $closedBrackets = substr_count($this->string, ')');
        return $closedBrackets === $openedBrackets;
    }
}