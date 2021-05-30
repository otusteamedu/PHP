<?php

namespace Src\Decorator;

use Src\Observer\SubjectMeal;

class IngredientDecorator extends Dish
{
    public function addIngredient(string $ingredient): Recipe
    {
        /**@var SubjectMeal $dish */
        $dish = parent::addIngredient($ingredient);
        $dish->$ingredient = true;
        $dish->ingredients[] = $ingredient;
        return $dish;
    }
}
