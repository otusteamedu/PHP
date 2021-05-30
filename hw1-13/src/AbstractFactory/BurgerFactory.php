<?php
namespace Src\AbstractFactory;


class BurgerFactory implements AbstractFoodFactory
{
    public function cookFood() : AbstractFoodInterface
    {
        return new Burger();
    }
}