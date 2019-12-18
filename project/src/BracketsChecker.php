<?php


namespace Checkers;


class BracketsChecker extends Checker
{
    private static $glyphs = [
        '[' => 1,
        '{' => 1,
        '<' => 1,
        '(' => 1,
        ']' => -1,
        '}' => -1,
        '>' => -1,
        ')' => -1,
    ];

    function checkBrackets($string) {
        if (!empty($string)) {
            $chars = str_split($string);
            $bracketCounter = 0;
            foreach ($chars as $char) {
                if ($bracketCounter < 0) {

                    return false;
                }
                if (!empty(BracketsChecker::$glyphs[$char])) {
                    $bracketCounter += BracketsChecker::$glyphs[$char];
                }
            }
            if ($bracketCounter === 0) {

                return true;
            }
        }

        return false;
    }
}