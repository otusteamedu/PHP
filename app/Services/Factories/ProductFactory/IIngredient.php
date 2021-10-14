<?php

namespace App\Services\Factories\ProductFactory;

interface IIngredient
{
    public function addToRecipe(): self;
    public function addToProduct(): self;
    public function prepare(): self;
    public function setStatusReady(): self;
}