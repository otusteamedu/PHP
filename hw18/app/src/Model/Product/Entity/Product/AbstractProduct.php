<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

use App\Model\Product\Entity\Ingredient\IngredientCollection;
use App\Model\Product\Entity\Ingredient\IngredientInterface;
use App\Model\Product\Entity\Product\Observer\ObserverInterface;
use DomainException;
use InvalidArgumentException;

abstract class AbstractProduct implements ProductInterface
{
    private const STATUS__NOT_COOKED = 'not_cooked';
    private const STATUS__COOKED     = 'cooked';
    private const STATUS__DISPOSE_OF = 'dispose_of';
    protected string             $name;
    private string               $status;
    private IngredientCollection $ingredients;
    private array                $observers          = [];
    private bool                 $isCustomRecipeUsed = false;

    public function __construct()
    {
        $this->status = self::STATUS__NOT_COOKED;
        $this->ingredients = new IngredientCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->assertIsNotCooked();
        $this->assertIsNotDisposeOf();

        if ($this->isIngredientExist($ingredient)) {
            throw new InvalidArgumentException('Ингредиент уже добавлен');
        }

        $this->ingredients->append($ingredient);
    }

    public function areIngredientsExist(IngredientCollection $ingredients): bool
    {
        /* @var IngredientInterface $existingIngredient */
        foreach ($ingredients as $ingredient) {
            if ($this->isIngredientExist($ingredient)) {
                return true;
            }
        }

        return false;
    }

    private function isIngredientExist(IngredientInterface $ingredient): bool
    {
        /* @var IngredientInterface $existingIngredient */
        foreach ($this->ingredients as $existingIngredient) {
            if ($existingIngredient->isEqual($ingredient)) {
                return true;
            }
        }

        return false;
    }

    public function getIngredients(): IngredientCollection
    {
        return $this->ingredients;
    }

    public function markIsCustomRecipeUsed(): void
    {
        $this->isCustomRecipeUsed = true;
    }

    public function isCustomRecipeUsed(): bool
    {
        return $this->isCustomRecipeUsed;
    }

    public function cook(): void
    {
        $this->assertIsNotCooked();
        $this->assertIsNotDisposeOf();
        $this->assertIngredientsAreSpecified();

        $this->status = self::STATUS__COOKED;

        $this->notify(Events::EVENT__COOKED);
    }

    private function isCooked(): bool
    {
        return ($this->status === self::STATUS__COOKED);
    }

    public function disposeOf(): void
    {
        $this->status = self::STATUS__DISPOSE_OF;
    }

    private function isDisposeOf(): bool
    {
        return ($this->status === self::STATUS__DISPOSE_OF);
    }

    public function addObserver(ObserverInterface $observer, string $eventName = '*'): void
    {
        $this->observers[$eventName][] = $observer;
    }

    public function removeObserver(ObserverInterface $observer, string $eventName = '*'): void
    {
        foreach ($this->getObserversByEvent($eventName) as $key => $attachedObserver) {
            if ($attachedObserver === $observer) {
                unset($this->observers[$eventName][$key]);
            }
        }
    }

    public function notify(string $eventName = '*'): void
    {
        /* @var ObserverInterface $observer */
        foreach ($this->getObserversByEvent($eventName) as $observer) {
            $observer->handle($this, $eventName);
        }
    }

    private function getObserversByEvent(string $eventName = '*'): array
    {
        $group = $this->observers[$eventName];
        $all = (!empty($this->observers['*']) ? $this->observers['*'] : []);

        return array_merge($group, $all);
    }

    private function assertIsNotCooked(): void
    {
        if ($this->isCooked()) {
            throw new DomainException('Продукт уже приготовлен');
        }
    }

    private function assertIsNotDisposeOf(): void
    {
        if ($this->isDisposeOf()) {
            throw new DomainException('Продукт утилизирован');
        }
    }

    private function assertIngredientsAreSpecified(): void
    {
        if ($this->ingredients->count() === 0) {
            throw new DomainException('Не указаны ингредиенты');
        }
    }
}