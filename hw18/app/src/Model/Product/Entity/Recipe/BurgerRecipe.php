<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use App\Model\Product\Entity\Ingredient\Bun;
use App\Model\Product\Entity\Ingredient\Cutlet;
use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\LettuceLeaves;
use App\Model\Product\Entity\Ingredient\Onion;
use App\Model\Product\Entity\Ingredient\Pepper;
use App\Model\Product\Entity\Ingredient\Tomato;

class BurgerRecipe extends AbstractRecipe
{
    public function __construct()
    {
        $this->ingredients = new IngredientCollection(
            [
                new Bun(true),
                new Cutlet(),
                new Tomato(),
                new LettuceLeaves(),
                new Onion(),
                new Pepper(),
            ]
        );
    }
}