<?php


namespace App\Shop\Factory;


class Ingredients implements \App\Shop\Factory\Interfaces\Ingredients
{
    private array $ingredients = [];

    public function add(string $name): Ingredients
    {
        $this->ingredients[] = mb_strtolower($name);
        return $this;
    }

    public function remove(string $name): Ingredients
    {
        $this->ingredients = array_filter($this->ingredients, static function ($item) use ($name) {
            return $item !== mb_strtolower($name);
        });
        return $this;
    }

    public function getAll(): array
    {
        return $this->ingredients;
    }
}