<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Strategy;

use UnexpectedValueException;

class ProductStrategyFactory
{
    public static function create(string $productName): ProductStrategyInterface
    {
        $strategyClassName = __NAMESPACE__ . "\\{$productName}Strategy";

        if (!class_exists($strategyClassName, true)) {
            throw new UnexpectedValueException("Неизвестный продукт $productName");
        }

        return new $strategyClassName();
    }
}