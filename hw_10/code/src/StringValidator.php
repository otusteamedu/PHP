<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class StringValidator
{
    private const BRACKETS_SET = [
        ['(', ')'],
        ['{', '}'],
        ['[', ']']
    ];

    public static function isAllBracketsClosedProperly(string $string): bool
    {
        foreach (self::BRACKETS_SET as $brackets) {
            if (!self::isBracketsClosedProperly($string, $brackets)) {
                return false;
            }
        }

        return true;
    }

    private static function isBracketsClosedProperly(string $string, array $bracketsSet): bool
    {
        return substr_count($string, $bracketsSet[0]) === substr_count($string, $bracketsSet[1]);
    }
}