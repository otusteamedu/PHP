<?php


namespace Src\Decorator;


class IngredientDecorator extends FoodDecorator
{
    public function addIngredient(string $ingredient): SpecialRecipe
    {
        $meal = parent::addIngredient($ingredient);
        $meal->$ingredient = true;
        $meal->ingredients[] = $ingredient;
        return $meal;
    }
}