<?php


namespace Classes;


class Validate
{
    // Функция валидации запроса POST. Если запрос с именем string существует, возвщаем true, в противном случае - false.
    public static function check_string($string)
    {

        if (empty($string)) {
            return false;
        }

        return true;
    }
}