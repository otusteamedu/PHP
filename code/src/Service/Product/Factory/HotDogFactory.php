<?php


namespace App\Service\Product\Factory;


use App\Entity\HotDog;
use App\Entity\Ingredient;
use App\Entity\ProductInterface;

class HotDogFactory extends AbstractProductFactory
{

    public function createProduct(): ProductInterface
    {
        $hotDog = new HotDog();
        $ingredient = new Ingredient(HotDog::BASE);
        $hotDog->addIngredient($ingredient);

        return $hotDog;
    }

}
