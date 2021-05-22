<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Proxy;

use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\IngredientInterface;
use App\Model\Product\Entity\Product\Events;
use App\Model\Product\Entity\Product\ProductInterface;
use App\Model\Product\Entity\Product\Observer\ObserverInterface;

class ProxyProduct implements ProductInterface
{
    private ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->product->addIngredient($ingredient);
    }

    public function areIngredientsExist(IngredientCollection $ingredients): bool
    {
        return $this->product->areIngredientsExist($ingredients);
    }

    public function getIngredients(): IngredientCollection
    {
        return $this->product->getIngredients();
    }

    public function markIsCustomRecipeUsed(): void
    {
        $this->product->markIsCustomRecipeUsed();
    }

    public function isCustomRecipeUsed(): bool
    {
        return $this->product->isCustomRecipeUsed();
    }

    public function cook(): void
    {
        $this->notify(Events::EVENT__PRE_COOK);

        $this->product->cook();

        $this->notify(Events::EVENT__POST_COOK);
    }

    public function disposeOf(): void
    {
        $this->product->disposeOf();
    }

    public function addObserver(ObserverInterface $observer, string $eventName = '*'): void
    {
        $this->product->addObserver($observer, $eventName);
    }

    public function removeObserver(ObserverInterface $observer, string $eventName = '*'): void
    {
        $this->product->removeObserver($observer, $eventName);
    }

    public function notify(string $eventName = '*'): void
    {
        $this->product->notify($eventName);
    }
}