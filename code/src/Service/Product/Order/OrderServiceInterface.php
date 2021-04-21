<?php


namespace App\Service\Product\Order;


interface OrderServiceInterface
{
    public function createOrder(
        string $email, string $productType, array $productOptions = null
    ): ProductOrderInterface;
}
