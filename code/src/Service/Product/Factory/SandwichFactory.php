<?php


namespace App\Service\Product\Factory;


use App\Entity\Ingredient;
use App\Entity\ProductInterface;
use App\Entity\Sandwich;

class SandwichFactory extends AbstractProductFactory
{
    public function createProduct(): ProductInterface
    {
        $sandwich = new Sandwich();
        $ingredient = new Ingredient(Sandwich::BASE);
        $sandwich->addIngredient($ingredient);

        return $sandwich;
    }
}
