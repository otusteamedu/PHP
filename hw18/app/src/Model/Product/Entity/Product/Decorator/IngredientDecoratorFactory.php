<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Decorator;

use App\Model\Product\Entity\Product\ProductInterface;
use UnexpectedValueException;

class IngredientDecoratorFactory
{
    public static function create(ProductInterface $product, string $ingredientName): ProductInterface
    {
        $decoratorClassName = __NAMESPACE__ . "\\{$ingredientName}Decorator";

        if (!class_exists($decoratorClassName)) {
            throw new UnexpectedValueException("Неизвестный ингредиент $ingredientName");
        }

        return new $decoratorClassName($product);
    }
}