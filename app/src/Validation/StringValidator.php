<?php 

namespace Validation;

class StringValidator
{
    public function __construct()
    {

    }

    public function checkString(String $string): array
    {
        if(strlen($string) < 2) return [false, "Строка слишком короткая!"];

        if(preg_match('/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/', $string))
            return [true, 'Запрос корректный, строка подошла под условия'];

        return [false, 'Ошибка в соотношении открывающих и закрывающих скобок!'];
    }
}