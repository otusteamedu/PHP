<?php


namespace App\Service\Product\Factory;


use App\Entity\ProductInterface;

interface ProductFactoryInterface
{
    public function createProduct(): ProductInterface;
    public function createProducts(int $count): array;
}
