<?php

namespace App\Entities;

class OrderBuilder
{
    public $id;
    public $name = null;
    public $clientId;
    public $couponId = null;
    public $priceRub = 0;
    public $productList = array();
    public $deliveryServiceList = array();

    public function __construct(
        $clientId
    )
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
     * @param ProductEntity $product
     */
    public function addProduct(ProductEntity $product): void
    {
        $this->productList[] = $product;
    }

    /**
     * @param DeliveryServiceEntity $deliveryService
     */
    public function addDeliveryServiceList(DeliveryServiceEntity $deliveryService): void
    {
        $this->deliveryServiceList[] = $deliveryService;
    }

    public function build() {
        if (empty($this->productList)) {
            new \Exception('Заказ не может быть создан, добавьте продукты');
        }

        if (empty($this->deliveryServiceList)) {
            new \Exception('Заказ не может быть создан, выберите способ доставки');
        }

        $this->calculateFullPrice();
        return new OrderEntity($this);
    }

    private function calculateFullPrice()
    {
        // todo вычисление полной стоимости товара
    }
}