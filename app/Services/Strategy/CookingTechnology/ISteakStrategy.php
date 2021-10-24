<?php

namespace App\Services\Strategy\CookingTechnology;


interface ISteakStrategy
{
    public function prepare(): string;
}