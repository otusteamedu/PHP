<?php


namespace App\Restaurant\Factory;


use App\Restaurant\Factory\Interfaces\Ingredients;

class Sandwich implements Interfaces\Sandwich
{
    private Ingredients $ingredients;

    public function __construct()
    {
        $this->ingredients = new \App\Restaurant\Factory\Ingredients();
    }

    public function cook(): string
    {
        return 'Burger with ' . implode(', ', $this->ingredients()->getAll());
    }

    public function ingredients(): Ingredients
    {
        return $this->ingredients;
    }
}