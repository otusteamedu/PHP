<?php


namespace App\Console;


class Console
{
    protected function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }
}
