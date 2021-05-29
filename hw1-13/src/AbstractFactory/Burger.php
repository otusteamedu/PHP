<?php
namespace Src\AbstractFactory;

class Burger implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Burger';
    }

    public function addIngredient(string $ingredient)
    {
        // TODO: Implement addIngredient() method.
    }
}