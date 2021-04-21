<?php


namespace App\Service\Product\Strategy;


use App\Service\Product\Factory\ProductFactoryInterface;

interface ProductStrategyInterface
{
    public function getFactory(string $productType): ProductFactoryInterface;
}
