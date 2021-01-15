<?php

namespace Homework;

use Classes\CountBracket;
use Classes\Validate;

class Homework
{
    private $string = '()()()()()';

    // Отправляем заголовки в зависимости от ответа функции валидации.
    public function run() : void
    {

        if ($this->check() && $this->count()) {
            header('HTTP/1.1 200 OK');
            echo "Успех";
        } else {
            header('HTTP/1.1 400 Bad request');
            echo "Ошибка";
        }

    }

    private function check()
    {
        return Validate::check_string($this->string);
    }

    private function count()
    {
        return CountBracket::brackets_count($this->string);
    }


} 