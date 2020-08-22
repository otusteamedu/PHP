<?php


namespace Penguin\Helpers;


class StringHelper
{
    public static function onlyParenthesis(string $string) : string
    {
        return preg_replace("#[^\(\)]#", "", $string);
    }

    public static function parenthesisValidator(string $string) : bool
    {
        $openCount = 0;

        if ($string[0] === ')') {
            return false;
        }

        for ($curIndex = 0; $curIndex < strlen($string); $curIndex++) {
            if ($string[$curIndex] === '(') {
                $openCount++;
            } else {
                $openCount--;
            }

            if ($openCount < 0) {
                return false;
            }
        }

        return !(bool)$openCount;
    }
}