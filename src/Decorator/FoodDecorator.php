<?php


namespace Src\Decorator;

class FoodDecorator implements SpecialRecipe
{
    public SpecialRecipe $meal;

    public function __construct(SpecialRecipe $meal)
    {
        $this->meal = $meal;
    }

    public function addIngredient(string $ingredient): SpecialRecipe
    {
        return $this->meal;
    }
}