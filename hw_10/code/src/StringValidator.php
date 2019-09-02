<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class StringValidator
{
    public static function isAllBracketsClosedProperly(string $string): bool
    {
        $re = '/(\(((?R)|)\))*/';
        preg_match($re, $string, $matches, PREG_OFFSET_CAPTURE, 0);

        if (isset($matches[0][0]) && $matches[0][0] === $string) {
            return true;
        }
        return false;
    }
}