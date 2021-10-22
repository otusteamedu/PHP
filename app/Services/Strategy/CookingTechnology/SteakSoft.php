<?php

namespace App\Services\Strategy\CookingTechnology;

class SteakSoft implements ISteakStrategy
{

    public function prepare(): string
    {
        return "Жарится 1 минуту".PHP_EOL;
    }
}