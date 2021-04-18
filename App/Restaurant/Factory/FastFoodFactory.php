<?php


namespace App\Restaurant\Factory;


use App\Restaurant\Factory\Interfaces\Burger;
use App\Restaurant\Factory\Interfaces\HotDog;
use App\Restaurant\Factory\Interfaces\Sandwich;

class FastFoodFactory implements \App\Restaurant\Factory\Interfaces\FastFoodFactory
{

    public function createBurger(): Burger
    {
        return new \App\Restaurant\Factory\Burger();
    }

    public function createSandwich(): Sandwich
    {
        return new \App\Restaurant\Factory\Sandwich();
    }

    public function createHotDog(): HotDog
    {
        return new \App\Restaurant\Factory\HotDog();
    }
}