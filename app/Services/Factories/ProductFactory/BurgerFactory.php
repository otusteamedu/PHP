<?php

namespace App\Services\Factories\ProductFactory;


use App\Services\Helpers\Recipes\BurgerRecipe;
use App\Services\Products\Base\BurgerBase;
use App\Services\Products\Ingredients\Cheese;
use App\Services\Products\Ingredients\Ingredient;
use App\Services\Products\Ingredients\Onion;
use App\Services\Products\Ingredients\Pepper;
use App\Services\Products\Ingredients\Salad;
use App\Services\Products\Ingredients\Steak;
use App\Services\Products\Sauces\Ketchup;
use App\Services\Products\Sauces\Mayonnaise;
use App\Services\Products\Sauces\Sauce;
use App\Services\Products\Sauces\Tabasco;


class BurgerFactory extends AbstractProductFactory
{
    /**
     * @var string
     */
    private string $size;


    /**
     * @param string $size
     */
    public function __construct(string $size = '')
    {
        if (empty($size)) {
            $size = BurgerRecipe::getSize();
        }
        $this->size = $size;
    }

    /**
     * @param string $type
     * @return AbstractProductBase
     */
    public function createBase(string $type): AbstractProductBase
    {
        if (empty($type)) {
            $type = BurgerRecipe::getBase();
        }
        return new BurgerBase($this->size, $type);
    }

    /**
     * @param array $customIngredientsList
     * @return IIngredient
     */
    public function createIngredients(array $customIngredientsList): IIngredient
    {
        $ingredientsList = array_unique(array_merge(BurgerRecipe::getIngredient(), $customIngredientsList));
        $ingredient = new Ingredient();
        foreach ($ingredientsList as $item => $type) {
            $ingredient = match ($item) {
                'onion'     => (new Onion($ingredient))->setType($type),
                'pepper'    => (new Pepper($ingredient))->setType($type),
                'steak'    => (new Steak($ingredient))->setType($type),
                'salad'     => (new Salad($ingredient))->setType($type),
                'cheese'    => (new Cheese($ingredient))->setType($type),
                default     => $ingredient
            };
        }
        return $ingredient;
    }

    /**
     * @param array $customSaucesList
     * @return ISauce
     */
    public function createSauces(array $customSaucesList): ISauce
    {
        $saucesList = array_unique(array_merge(BurgerRecipe::getSauces(), $customSaucesList));
        $sauce = new Sauce();
        foreach ($saucesList as $item => $type) {
            $sauce = match ($item) {
                'ketchup'       => (new Ketchup($sauce))->setType($type),
                'mayonnaise'    => (new Mayonnaise($sauce))->setType($type),
                'tabasco'       => (new Tabasco($sauce))->setType($type),
                default         => $sauce
            };
        }
        return $sauce;
    }
}