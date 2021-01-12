<?php

namespace Homework;

class Homework
{

    function __construct()
    {
        // Расскоментирова строку, можем проверить результат при отправке POST переменной.
        // Задаём переменную POST.
//        $_POST['string'] = "(()()()()))((((()()()))(()()()(((()))))))";
    }

    // Отправляем заголовки в зависимости от ответа функции валидации.
    public function check()
    {

        if ( self::validate() && self::brackets_count() && self::back_brackets_count()) {
            header('HTTP/1.1 200 OK');
            return;
        }

        header('HTTP/1.1 400 Bad request');
    }

    // Функция валидации запроса POST. Если запрос с именем string существует, возвщаем true, в противном случае - false.
    private function validate()
    {

        if (empty( trim($_POST['string']) )) {
            return false;
        }


        return true;
    }

    // Проверяем количество открывающих скобок. Если соответствует указанному значению, возвращаем true.
    private function brackets_count ()
    {
        $arr = trim($_POST['string']);

        if ( substr_count($arr, '(') === 20 ) {
            return true;
        }

        return false;
    }

    // Проверяем количество закрывающих скобок. Если соответствует указанному значению, возвращаем true.
    private function back_brackets_count ()
    {
        $arr = trim($_POST['string']);

        if ( substr_count($arr, ')') === 21 ) {
            return true;
        }

        return false;
    }


}