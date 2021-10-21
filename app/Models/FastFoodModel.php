<?php

namespace App\Models;


use App\Services\Orders\ProductOrder;

class FastFoodModel implements IModel
{
    private ProductOrder $order;

    /**
     * @param ProductOrder $productOrder
     */
    public function __construct(ProductOrder $productOrder)
    {
       $this->order = $productOrder;
    }

    public function createProduct(string $customBaseType = '', array $customIngredients = [], array $customSauces = []): ProductOrder
    {
        return $this->order
            ->getOrder()
            ->createProduct($customBaseType, $customIngredients, $customSauces);
    }

    public function prepareProduct(ProductOrder $productOrder): ProductOrder
    {
        return $productOrder->prepareProduct();
    }

    public function getProduct(ProductOrder $productOrder): string
    {
        return $productOrder->getProduct();
    }
}