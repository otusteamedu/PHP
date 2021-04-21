<?php


namespace Src\Decorator;


class OnionDecorator extends FoodDecorator
{
    public function addIngredient() : SpecialRecipe
    {
        $meal = parent::addIngredient();
        $meal->extraOnion = true;
        $meal->ingredients[] = 'onion';
        return $meal;
    }
}