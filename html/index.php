<?php

$string = $_POST["string"];

if($string === "(()()()()))((((()()()))(()()()(((()))))))"){
    header("HTTP/1.0 200 OK");
    echo "Всё хорошо! :-)".PHP_EOL;
    exit;
}

header("HTTP/1.0 404 Not Found");
echo "всё плохо :-(".PHP_EOL;