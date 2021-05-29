<?php

namespace Src\Decorator;


class IngredientDecorator extends Dish
{
    public function addIngredient(string $ingredient): Recipe
    {
        $dish = parent::addIngredient($ingredient);
        $dish->$ingredient = true;
        $dish->ingredients[] = $ingredient;
        return $dish;
    }
}
