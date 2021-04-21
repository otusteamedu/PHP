<?php


namespace App\Entity;


interface ProductInterface
{
    public function getType(): string;
    public function getDefaultOptions(): array;
    public function addIngredient(IngredientInterface $ingredient): self;
    public function __clone();
    public function __toString();
}
