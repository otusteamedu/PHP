<?php

namespace APankov;
class BracketsChecker
{
    public static function checkRequest(): bool
    {
        if ($brackets = trim($_POST['string'])) {
            return self::checkBrackets($brackets);
        }
        return false; // а тут можно отдавать 500, а не просто false, а то 2 одинаковых ответа на разные ошибки, хорошо ли это?
    }


    public static function checkBrackets(String $string): bool
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
        return (empty($stack));
    }
}