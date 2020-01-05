<?php

$string = $_POST["string"];

$arr = str_split($string);
$status = 0;

try {
    if(trim($string) == "") throw new Exception("Пустая переменная string");
    foreach($arr as $a) {
        if($a == "(") $status += 1;
        if($a == ")") $status -= 1;
        if($status < 0) throw new Exception("Неправильный порядок скобок");
    }

    if($status != 0) throw new Exception("Количество открытых и закрытых скобок различно");

    header("HTTP/1.0 200 OK");
    print("Все просто отлично");
} catch (Exception $e) {
    http_response_code(400);
    print($e->getMessage());
}



