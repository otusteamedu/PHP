<?php


namespace Src\Decorator;


use SplSubject;

class CheeseDecorator extends FoodDecorator
{
    public function addIngredient() : SpecialRecipe
    {
        $meal = parent::addIngredient();
        $meal->extraCheese = true;
        $meal->ingredients[] = 'cheese';
        return $meal;
    }
}