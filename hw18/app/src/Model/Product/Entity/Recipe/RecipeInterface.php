<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use App\Model\Product\Entity\Ingredient\IngredientCollection;

interface RecipeInterface
{
    public function getIngredients(): IngredientCollection;

    public function getRequiredIngredients(): IngredientCollection;
}