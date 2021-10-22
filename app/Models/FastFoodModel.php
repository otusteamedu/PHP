<?php

namespace App\Models;


use App\Services\Orders\IProductOrder;
use App\Services\Orders\ProductOrder;
use App\Services\Orders\ProxyProductOrder;

class FastFoodModel implements IModel
{
    private ProxyProductOrder $order;

    /**
     * @param ProxyProductOrder $productOrder
     */
    public function __construct(ProxyProductOrder $productOrder)
    {
       $this->order = $productOrder;
    }

    public function createProduct(string $customBaseType = '', array $customIngredients = [], array $customSauces = []): IProductOrder
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