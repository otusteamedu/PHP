<?php

namespace App\Models;


use App\Services\Factories\ProductFactory\BurgerFactory;
use App\Services\Factories\ProductFactory\HotDogFactory;
use App\Services\Factories\ProductFactory\SandwichFactory;
use App\Services\Orders\ProductOrder;

class FastFoodModel implements IModel
{
    private ProductOrder $order;

    /**
     * @param array $product
     * @param array $ingredients
     */
    public function __construct(array $product, array $ingredients = [])
    {
       $this->order = match ($product['name']) {
           'Burger'     => new ProductOrder(new BurgerFactory($product['size'] ?? '')),
           'HotDog'     => new ProductOrder(new HotDogFactory($product['size'] ?? '')),
           'Sandwich'   => new ProductOrder(new SandwichFactory($product['size'] ?? '')),
       };
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