<?php


namespace App\Service\Product\Factory;


use App\Entity\ProductInterface;

abstract class AbstractProductFactory implements ProductFactoryInterface
{

    abstract public function createProduct(): ProductInterface;

    public function createProducts(int $count): array
    {
        $product = $this->createProduct();
        $products = [];
        while($count) {
            $clone = clone $product;
            array_push($products, $clone);
            $count--;
        }

        return $products;
    }
}
