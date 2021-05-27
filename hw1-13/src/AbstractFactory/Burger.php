<?php
namespace Src\AbstractFactory;

class Burger implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Burger';
    }
}