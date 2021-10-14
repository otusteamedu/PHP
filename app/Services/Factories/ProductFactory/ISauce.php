<?php

namespace App\Services\Factories\ProductFactory;

interface ISauce
{
    public function addToRecipe(): self;
    public function addToProduct(): self;
    public function setStatusReady(): self;
}