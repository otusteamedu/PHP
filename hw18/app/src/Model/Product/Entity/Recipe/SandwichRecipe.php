<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use App\Model\Product\Entity\Ingredient\Cheese;
use App\Model\Product\Entity\Ingredient\Ham;
use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\Onion;
use App\Model\Product\Entity\Ingredient\ToastBread;
use App\Model\Product\Entity\Ingredient\Tomato;

class SandwichRecipe extends AbstractRecipe
{
    public function __construct()
    {
        $this->ingredients = new IngredientCollection(
            [
                new ToastBread(true),
                new Ham(),
                new Cheese(),
                new Tomato(),
                new Onion(),
            ]
        );
    }
}