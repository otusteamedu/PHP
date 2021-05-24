<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\IngredientInterface;
use App\Model\Product\Entity\Product\Observer\ObservableInterface;

interface ProductInterface extends ObservableInterface
{
    public function getName(): string;

    public function addIngredient(IngredientInterface $ingredient): void;

    public function getIngredients(): IngredientCollection;

    public function areIngredientsExist(IngredientCollection $ingredients): bool;

    public function markIsCustomRecipeUsed(): void;

    public function isCustomRecipeUsed(): bool;

    public function cook(): void;

    public function disposeOf(): void;
}