<?php

namespace Src;


class Validator
{
    private string $string;

    public function __construct(string $string)
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
        $brackets = [];

        for($i = 0; $i < strlen($this->string); $i++) {
            switch ($this->string[$i]) {
                case '(':
                    $brackets[] = $this->string[$i];
                    break;
                case ')':
                    array_pop($brackets);
                    break;
                default:
                    break;
            }
        }

        return empty($brackets);
    }
}