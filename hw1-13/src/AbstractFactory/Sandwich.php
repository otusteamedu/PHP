<?php
namespace Src\AbstractFactory;

class Sandwich implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Sandwich';
    }
}