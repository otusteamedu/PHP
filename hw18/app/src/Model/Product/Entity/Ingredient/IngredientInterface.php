<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Ingredient;

interface IngredientInterface
{
    public function getName(): string;

    public function isEqual(IngredientInterface $otherIngredient): bool;

    public function isRequired(): bool;
}