<?php


namespace Src\AbstractFactory;


class BurgerFactory extends BaseFactory implements FoodFactory
{
    public function cookFood() : AbstractFood
    {
        return new Burger();
    }
}