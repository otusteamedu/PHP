<?php

namespace App\Services;

class OrderBuilder
{
    public $id;
    public $name;
    public $clientId;
    public $couponId;
    public $price = 0;
    public $productList = [];
    public $deliveryServiceList = [];

    public function __construct(int $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param mixed $name
     */
    public function addName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $clientId
     */
    public function addClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @param mixed $couponId
     */
    public function addCouponId($couponId): void
    {
        $this->couponId = $couponId;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->productList[] = $product;
    }

    /**
     * @param DeliveryService $deliveryService
     */
    public function addDeliveryServiceList(DeliveryService $deliveryService): void
    {
        $this->deliveryServiceList[] = $deliveryService;
    }

    public function build()
    {
        if (!$this->productList) {
            throw new \Exception('Заказ не может быть создан, добавьте продукты');
        }

        if (!$this->deliveryServiceList) {
            throw new \Exception('Заказ не может быть создан, выберите способ доставки');
        }

        $this->price = $this->calculateFullPrice();
        $order = new Order();
        $order->name = $this->name;
        $order->clientId = $this->clientId;
        $order->couponId = $this->couponId;
        $order->price = $this->price;
        $order->productList = $this->productList;
        $order->deliveryPackageList = $this->deliveryServiceList;
        $order->save();

        return $order;
    }

    private function calculateFullPrice()
    {
       return true; // вычисление полной стоимости товара
    }
}