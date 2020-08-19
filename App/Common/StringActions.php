<?php

namespace Common;


class StringActions
{
    /**
     * Функция генерации hash строки
     * @param $hashString
     * @return StringActions
     */
    public static function generateHash($hashString) {
        return hash('ripemd160', $hashString);
    }

    /**
     * Функция генерации случайной строки
     * @param int $length
     * @return StringActions
     */
    public static function generateString($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $stringlength = strlen($chars) - 1;

        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $stringlength)];
        }

        return $code;
    }


}