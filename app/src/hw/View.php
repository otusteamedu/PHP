<?php


namespace Otus;


class View
{
    public static function showMessage(string $string)
    {
        header("Content-type: application/json; charset=utf-8");
        echo $string;
    }

    public static function showResult($data)
    {
        header("Content-type: application/json; charset=utf-8");
        print_r($data);
    }
}