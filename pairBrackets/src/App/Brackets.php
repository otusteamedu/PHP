<?php

namespace App;

use http\Exception\InvalidArgumentException;

class Brackets
{
public function matchBrackets(string $str): bool
    {
        $count = 0;

        while (mb_strlen($str) > 0) {
            $sym = mb_substr($str, 0, 1);
            if ($sym !== ' ' && $sym !== "\n" && $sym !== "\t" && $sym !== "\r" && $sym !== '(' && $sym !== ')') {
                throw new InvalidArgumentException();
            }
            if ($sym === '(') {
                $count++;
            } elseif ($sym === ')') {
                $count--;
                //closed bracket without opened bracket
                if ($count < 0) {
                    return false;
                }
            }
            $str = mb_substr($str, 1, mb_strlen($str) - 1);
        }

        if ($count === 0) {
            return true;
        } else {
            return false;
        }
    }
}