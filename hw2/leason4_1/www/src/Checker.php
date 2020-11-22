<?php

class Checker
{
    /**
     * Проверка скобочной последовательности
     *
     * @param $inStr
     *
     * @return bool
     * @see https://neerc.ifmo.ru/wiki/index.php?title=Правильные_скобочные_последовательности
     */
    public function check($inStr)
    {
        $c   = 0;
        $len = strlen($inStr);
        for ($i = 0; $i < $len; $i++) {
            if ($inStr[$i] == '(') {
                $c++;
            } else {
                $c--;
            }
            if ($c < 0) return false;
        }

        return $c == 0;
    }
}