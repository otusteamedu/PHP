<?php


namespace App\Service\Product\Preparation;


use App\Entity\ProductInterface;
use App\Service\Product\Order\ProductOrderInterface;

interface ProductPreparationInterface
{
    public function process(ProductOrderInterface $order): ProductInterface;
}
