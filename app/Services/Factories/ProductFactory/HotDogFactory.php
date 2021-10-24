<?php


namespace App\Services\Factories\ProductFactory;


use App\Services\Helpers\Recipes\HotDogRecipe;
use App\Services\Products\Base\HotDogBase;
use App\Services\Products\Ingredients\Cheese;
use App\Services\Products\Ingredients\Ingredient;
use App\Services\Products\Ingredients\Onion;
use App\Services\Products\Ingredients\Pepper;
use App\Services\Products\Ingredients\Sausage;
use App\Services\Products\Sauces\Ketchup;
use App\Services\Products\Sauces\Mayonnaise;
use App\Services\Products\Sauces\Sauce;
use App\Services\Products\Sauces\Tabasco;


class HotDogFactory extends AbstractProductFactory
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
            $size = HotDogRecipe::getSize();
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
            $type = HotDogRecipe::getBase();
        }
        return new HotDogBase($this->size, $type);
    }

    /**
     * @param array $customIngredientsList
     * @return IIngredient
     */
    public function createIngredients(array $customIngredientsList): IIngredient
    {
        $ingredientsList = array_unique(array_merge(HotDogRecipe::getIngredient(), $customIngredientsList));
        $ingredient = new Ingredient();
        foreach ($ingredientsList as $item => $type) {
            $ingredient = match ($item) {
                'onion'     => (new Onion($ingredient))->setType($type),
                'pepper'    => (new Pepper($ingredient))->setType($type),
                'sausage'   => (new Sausage($ingredient))->setType($type),
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
        $saucesList = array_unique(array_merge(HotDogRecipe::getSauces(), $customSaucesList));
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