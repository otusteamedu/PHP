<?php

namespace App\Services\Strategy\CookingTechnology;

use App\Services\Products\Ingredients\Steak;

class SteakMiddle implements ISteakStrategy
{

    public function prepare(): string
    {
       return "Жарится 2 минуты".PHP_EOL;
    }
}