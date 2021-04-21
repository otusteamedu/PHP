<?php


namespace App\Entity;


class Ingredient implements IngredientInterface
{
    const POSTFIX_DOUBLE = ' (double)';
    private string $name;
    private bool $isDouble;

    public function __construct(string $name, $isDouble = false)
    {
        $this->name = $name;
        $this->isDouble = $isDouble;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDouble(): void
    {
        $this->isDouble = true;
    }


    public function __toString(): string
    {
        return $this->getName() . ($this->isDouble ? self::POSTFIX_DOUBLE : null);
    }
}
