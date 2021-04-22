<?php


namespace Src\AbstractFactory;


use Src\Decorator\SpecialRecipe;

class Burger extends BaseMeal
{
    public function __construct()
    {
        parent::__construct();
        $this->mealName = self::class;
    }

    public function getFoodName(): string
    {
        return 'Burger';
    }

    public function addIngredient(string $ingredient)
    {

    }
}