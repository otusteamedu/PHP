<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Recipe;

use UnexpectedValueException;

class RecipeFactory
{
    public static function create(string $productName): RecipeInterface
    {
        $recipeClassName = __NAMESPACE__ . "\\{$productName}Recipe";

        if (!class_exists($recipeClassName)) {
            throw new UnexpectedValueException("Рецепт не найден для продукта $productName");
        }

        return new $recipeClassName();
    }
}