<?php


namespace App;


class Message
{
    public static function output(string $string)
    {
        fwrite(\STDOUT, $string . PHP_EOL);
    }
}
