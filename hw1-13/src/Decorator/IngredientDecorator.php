<?php

namespace Src\Decorator;


class IngredientDecorator extends Dish
{
    public function addIngredient(string $ingredient): Recipe
    {
        $meal = parent::addIngredient($ingredient);
        $meal->$ingredient = true;
        $meal->ingredients[] = $ingredient;
        return $meal;
    }
}
