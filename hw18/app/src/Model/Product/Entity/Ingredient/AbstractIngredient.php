<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Ingredient;

abstract class AbstractIngredient implements IngredientInterface
{
    protected string $name;
    private bool     $isRequired;

    public function __construct(bool $isRequired = false)
    {
        $this->isRequired = $isRequired;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEqual(IngredientInterface $otherIngredient): bool
    {
        return $otherIngredient->getName() === $this->getName();
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}