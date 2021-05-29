<?php

namespace Src\Decorator;

class Dish implements Recipe
{
    public Recipe $ingredient;

    public function __construct(Recipe $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    public function addIngredient(string $ingredient): Recipe
    {
        return $this->ingredient;
    }
}