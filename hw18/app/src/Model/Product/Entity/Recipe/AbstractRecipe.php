<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\IngredientInterface;

abstract class AbstractRecipe implements RecipeInterface
{
    protected IngredientCollection $ingredients;

    public function getIngredients(): IngredientCollection
    {
        return $this->ingredients;
    }

    public function getRequiredIngredients(): IngredientCollection
    {
        $requiredIngredients = new IngredientCollection();

        /* @var IngredientInterface $ingredient */
        foreach ($this->ingredients as $ingredient) {
            if ($ingredient->isRequired()) {
                $requiredIngredients->append($ingredient);
            }
        }

        return $requiredIngredients;
    }
}