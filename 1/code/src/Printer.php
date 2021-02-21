<?php


namespace Src;


class Printer
{
    public static function printResult($result) {
        if ($result) {
            header("HTTP/1.0 200 Ok");
            echo 'Все ок' . PHP_EOL;
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo 'Все плохо' . PHP_EOL;
        };
    }
}