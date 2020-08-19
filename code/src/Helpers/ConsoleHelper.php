<?php


namespace Penguin\Helpers;


class ConsoleHelper
{
    public static function write()
    {
        return fgets(STDIN);
    }
}