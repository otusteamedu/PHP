<?php


namespace App\Restaurant\Factory;


class Ingredients implements \App\Restaurant\Factory\Interfaces\Ingredients
{
    private array $ingredients = [];

    public function add(string $name): \App\Restaurant\Factory\Interfaces\Ingredients
    {
        array_push($this->ingredients, mb_strtolower($name));
        return $this;
    }

    public function remove(string $name): \App\Restaurant\Factory\Interfaces\Ingredients
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