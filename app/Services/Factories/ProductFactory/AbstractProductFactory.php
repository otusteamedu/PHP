<?php

namespace App\Services\Factories\ProductFactory;


abstract class AbstractProductFactory
{
    abstract public function createBase(string $type): AbstractProductBase;
    abstract public function createIngredients(array $customIngredientsList): IIngredient;
    abstract public function createSauces(array $customSaucesList): ISauce;
}