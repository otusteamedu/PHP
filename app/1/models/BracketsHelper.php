<?php

namespace models;

class BracketsHelper
{
    public static function checkIsValid($string)
    {
        $arr_str = str_split($string);
        if (empty($arr_str)) return false;
        $stack = [];

        foreach ($arr_str as $char) {
            switch ($char) {
                case "(":
                    array_push($stack, $char);
                    break;
                case ")":
                    if (empty($stack)) return false;
                    array_pop($stack);
                    break;
            }
        }

        return empty($stack);
    }
}