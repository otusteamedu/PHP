<?php

$string = trim($_POST['string']);
$stringLength = strlen($string);

/**
 * Проверка корректности запроса
 */
if (!isset($_POST['string']) || $stringLength === 0) {
    error();
}

/**
 * Проверка на корректность кол-ва открытых и закрытых скобок
 */
for ($i = 0; $i < $stringLength; $i++) {
    $symbol = $string[$i];
    if ($symbol === '(') {
        $result += 1;
    } elseif ($symbol === ')') {
        $result -= 1;
    }
    if ($result < 0){
        error();
    }
}
$result === 0 ? success() : error();

/**
 * Отправка ответа 200 OK.
 */
function success()
{
    header('HTTP/1.1 200 OK');
    exit('200 OK');
}

/**
 * Отправка ответа 400 Bad Request.
 */
function error()
{
    header('HTTP/1.1 400 Bad Request');
    exit('400 Bad Request');
}
