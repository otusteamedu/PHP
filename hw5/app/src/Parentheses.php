<?php
namespace hw5;

class Parentheses
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function isValid(): bool
    {
        $balance = 0;

        for ($i = 0, $len = strlen($this->string); $i < $len; $i++) {
            if ($this->string[$i] == '(') {
                $balance++;
            } else {
                $balance--;
            }
            if ($balance < 0) {
                return false;
            }
        }

        return ($balance == 0);
    }
}