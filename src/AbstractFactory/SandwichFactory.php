<?php


namespace Src\AbstractFactory;


class SandwichFactory implements FoodFactory
{

    public function cookFood(): AbstractFood
    {
        return new Sandwich();
    }
}