<?php


namespace Otushw;


class View
{
    public static function showMessage(string $msg)
    {
        echo $msg . PHP_EOL;
    }

    public static function showChecking(bool $result)
    {
        $msg = 'The object is the same';
        if (!$result) {
            $msg = 'These are different objects';
        }
        echo $msg . PHP_EOL;
    }
}