<?php

namespace App\Services\Products\Ingredients;


use App\Services\Factories\ProductFactory\IIngredient;


class Cutlet extends Ingredient implements IIngredient
{

    const INGREDIENT_NAME = 'Котлета';

    /**
     * @param IIngredient $ingredient
     */
    public function __construct(IIngredient $ingredient)
    {
        parent::__construct();
        $this->ingredient = $ingredient;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Cutlet
     */
    public function setType(string $type): Cutlet
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->ingredientsList = $this->ingredient->toArray();
        $this->ingredientsList['Cutlet'] = parent::ingredientToArray();
        return $this->ingredientsList;
    }
}