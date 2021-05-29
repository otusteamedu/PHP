<?php
namespace Src\AbstractFactory;

use Src\Decorator\Recipe;

interface AbstractFoodInterface extends Recipe
{
    public function getFoodName(): string;
}