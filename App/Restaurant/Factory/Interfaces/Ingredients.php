<?php

namespace App\Restaurant\Factory\Interfaces;


interface Ingredients
{
    public function add(string $name): Ingredients;

    public function remove(string $name): Ingredients;

    public function getAll(): array;
}