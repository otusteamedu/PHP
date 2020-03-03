<?php

namespace App\Services;

/**
 * Проверка правильности порядка скобок.
 * [{()}]() -> true
 * {{[]}) -> false
 */
class Brackets
{
    private const BRACKETS_MAP = [
        ']' => '[',
        '}' => '{',
        ')' => '(',
    ];

    /**
     * @param string $str
     * @return bool
     */
    public static function test(string $str): bool
    {
        if (empty($str)) {
            throw new \DomainException('String is empty.');
        }

        $openBrackets = [];

        for ($i = 0; $i < strlen($str); ++$i) {
            if (self::isOpenBracket($str[$i])) {
                $openBrackets[] = $str[$i];
                continue;
            }

            if (self::isCloseBracket($str[$i])) {
                $openTag = self::BRACKETS_MAP[$str[$i]];
                if ($openTag != array_pop($openBrackets)) {
                    return false;
                }

                continue;
            }

            return false;
        }

        return empty($openBrackets);
    }

    /**
     * @param string $char
     * @return bool
     */
    private static function isOpenBracket(string $char): bool
    {
        return in_array($char, self::BRACKETS_MAP);
    }

    /**
     * @param string $char
     * @return bool
     */
    private static function isCloseBracket(string $char): bool
    {
        return array_key_exists($char, self::BRACKETS_MAP);
    }
}
