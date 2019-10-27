<?php

namespace App;

class BracketsChecker
{
    public function check(string $line)
    {
        $count = 0;
        foreach (str_split($line) as $char) {
            if ($char == '(') {
                $count++;
            } else if ($char == ')') {
                $count--;
            }
            if ($count < 0) {
                return false;
            }
        }

        return $count === 0;
    }
}
