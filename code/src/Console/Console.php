<?php


namespace App\Console;


class Console
{
    const TAB = "\t";

    protected function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }
}
