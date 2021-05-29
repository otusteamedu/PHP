<?php
namespace Src\AbstractFactory;
use Src\Observer\SubjectMeal;

class Hotdog extends SubjectMeal
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
