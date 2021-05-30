<?php
namespace Src\AbstractFactory;
use Src\Observer\SubjectMeal;

class Sandwich extends SubjectMeal
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