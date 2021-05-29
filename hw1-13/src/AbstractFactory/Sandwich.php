<?php
namespace Src\AbstractFactory;

class Sandwich implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Sandwich';
    }

    public function addIngredient(string $ingredient)
    {
        // TODO: Implement addIngredient() method.
    }
}