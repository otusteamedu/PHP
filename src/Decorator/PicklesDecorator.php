<?php


namespace Src\Decorator;


class PicklesDecorator extends FoodDecorator
{
    public function addIngredient() : SpecialRecipe
    {
        $meal = parent::addIngredient();
        $meal->extraPickles = true;
        $meal->ingredients[] = 'pickles';
        return $meal;
    }
}