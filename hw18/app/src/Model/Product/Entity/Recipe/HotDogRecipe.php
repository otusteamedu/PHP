<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use App\Model\Product\Entity\Ingredient\Bun;
use App\Model\Product\Entity\Ingredient\Cucumber;
use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\Onion;
use App\Model\Product\Entity\Ingredient\Sausage;
use App\Model\Product\Entity\Ingredient\Tomato;

class HotDogRecipe extends AbstractRecipe
{
    public function __construct()
    {
        $this->ingredients = new IngredientCollection(
            [
                new Bun(true),
                new Sausage(),
                new Cucumber(),
                new Tomato(),
                new Onion(),
            ]
        );
    }
}