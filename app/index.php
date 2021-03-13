<?php

define("BAD", "400 Bad Request");
define("OK", "200 OK");

function response($header, $body)
{
    header('HTTP/1.1 '.$header);
    echo $body."\n";
    exit;
}

function checkString($string)
{
    if(strlen($string) < 2) return [BAD, "Строка слишком короткая!"];

    if(preg_match('/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/', $string))
        return [OK, 'Запрос корректный, строка подошла под условия'];

    return [BAD, 'Ошибка в соотношении открывающих и закрывающих скобок!'];
}

if(!$_POST) 
    response(BAD, "Метод запроса не является корректным!");

if(!array_key_exists('string', $_POST)) 
    response(BAD, "Отсутствует необходимый параметр 'string'");
 
$check_result = checkString($_POST['string']);

response($check_result [0], $check_result [1]);

