<?php


namespace Src\Decorator;

class FoodDecorator implements SpecialRecipe
{
    public SpecialRecipe $meal;

    public function __construct(SpecialRecipe $meal)
    {
        $this->meal = $meal;
    }

    public function addIngredient(): SpecialRecipe
    {
        return $this->meal;
    }
}