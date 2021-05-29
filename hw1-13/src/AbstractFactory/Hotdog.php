<?php
namespace Src\AbstractFactory;

class Hotdog implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Hotdog';
    }

    public function addIngredient(string $ingredient)
    {
        // TODO: Implement addIngredient() method.
    }
}
