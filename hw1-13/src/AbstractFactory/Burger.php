<?php
namespace Src\AbstractFactory;
use Src\Observer\SubjectMeal;

class Burger extends SubjectMeal
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