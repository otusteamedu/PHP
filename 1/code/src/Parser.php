<?php


namespace Src;

class Parser
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function parse(): bool
    {
        return $this->parseString($this->string);
    }

    private function parseString(string $string): bool
    {
        $len = strlen($string);
        $stack = [];
        for ($i = 0; $i < $len; $i++) {
            switch ($string[$i]) {
                case '(':
                    array_push($stack, 0);
                    break;
                case ')':
                    if (array_pop($stack) !== 0)
                        return false;
                    break;
                default:
                    break;
            }
        }
        return empty($stack);
    }
}