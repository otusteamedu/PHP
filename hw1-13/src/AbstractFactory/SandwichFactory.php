<?php
namespace Src\AbstractFactory;

class SandwichFactory implements AbstractFoodFactory
{
    public function cookFood(): AbstractFoodInterface
    {
        return new Sandwich();
    }
}