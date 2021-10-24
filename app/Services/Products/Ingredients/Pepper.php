<?php

namespace App\Services\Products\Ingredients;


use App\Services\Factories\ProductFactory\IIngredient;


class Pepper extends Ingredient implements IIngredient
{

    const INGREDIENT_NAME = 'Перец';

    /**
     * @param IIngredient $ingredient
     */
    public function __construct(IIngredient $ingredient)
    {
        parent::__construct();
        $this->ingredient = $ingredient;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->ingredientsList = $this->ingredient->toArray();
        $this->ingredientsList['Pepper'] = parent::ingredientToArray();
        return $this->ingredientsList;
    }
}