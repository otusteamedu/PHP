<?php

namespace App\Services\Strategy\CookingTechnology;

use App\Services\Products\Ingredients\Steak;

class SteakHard implements ISteakStrategy
{

    public function prepare(): string
    {
        return "Жарится 3 минуты".PHP_EOL;
    }
}