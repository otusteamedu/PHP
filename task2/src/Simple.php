<?php

namespace Code;
/**
 * @author Dima Baldin <baldin@tutu.ru>
 *
 * @description проверка числа на простоту
 */

class Simple
{
    /**
     * @param int $number
     * @return bool
     */
    public static function isSimple(int $number) : bool
    {
        if ($number == 1)
            return false;
        for ($i = 2; $i < round(sqrt($number)); $i++) {
            if ($number % $i == 0) {
                return false;
            }

        }
        return true;
    }
}
