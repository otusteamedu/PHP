<?php


namespace App\Service\Product\Factory;


use App\Entity\Burger;
use App\Entity\Ingredient;
use App\Entity\ProductInterface;

class BurgerFactory extends AbstractProductFactory
{
    public function createProduct(): ProductInterface
    {
        $burger = new Burger();
        $ingredient = new Ingredient(Burger::BASE);
        $burger->addIngredient($ingredient);

        return $burger;
    }
}
