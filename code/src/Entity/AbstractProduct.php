<?php


namespace App\Entity;


abstract class AbstractProduct implements ProductInterface
{
    protected string $type;
    protected array $ingredients = [];

    public function getType(): string
    {
        return $this->type;
    }

    public function addIngredient(IngredientInterface $ingredient): self
    {
        array_push($this->ingredients, $ingredient);
        return $this;
    }

    public function __clone()
    {
        $this->ingredients = array_map(
            fn($item) => clone $item,
            $this->ingredients
        );
    }

    public function __toString()
    {
        return sprintf(
            "%s\n%s",
            $this->getType(),
            implode(', ', $this->ingredients)
        );
    }
}
