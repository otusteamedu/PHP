<?php


namespace App\Restaurant\Decorators;


use App\Restaurant\Factory\Interfaces\Burger;
use App\Restaurant\Factory\Interfaces\Ingredients;

class BurgerDecorator implements \App\Restaurant\Factory\Interfaces\Burger
{

    private Burger $burger;
    public function __construct(Burger $burger)
    {
        $this->burger = $burger;
    }

    public function cook(): string
    {
        return  $this->burger->cook();
    }

    public function ingredients(): Ingredients
    {
        return $this->burger->ingredients();
    }
}