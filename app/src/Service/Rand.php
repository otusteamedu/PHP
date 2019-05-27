<?php

namespace App\Service;

/**
 * Class Rand
 * @package App\Service
 */
class Rand
{
    private const SIMBOLS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param int $length
     * @return string
     */
    public static function getRandStr(int $length = 10): string
    {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= self::SIMBOLS[rand(0, strlen(self::SIMBOLS))];
        }

        return $str;
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function getRandInt(int $min = 0, int $max = 1000): int
    {
        return rand($min, $max);
    }

    /**
     * @param int $min
     * @param int $max
     * @return float
     */
    public static function getRandFloat(int $min = 0, int $max = 1000): float
    {
        return (float)rand($min, $max);
    }

    /**
     * @return bool
     */
    public static function getRandBool(): bool
    {
        return rand(0, 1) ? true : false;
    }
}