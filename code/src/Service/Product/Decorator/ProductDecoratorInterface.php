<?php


namespace App\Service\Product\Decorator;


use App\Entity\ProductInterface;

interface ProductDecoratorInterface
{
    public function addIngredients(array $ingredients): ProductInterface;
}
