<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\DTO\Order;
use Ozycast\App\DTO\Client;
use Ozycast\App\DTO\ProductOrder;
use Ozycast\App\Interfaces\Discount;
use Ozycast\App\Interfaces\Delivery;
use Ozycast\App\Mappers\ProductMapper;

Class OrderBuilder
{
    /**
     * @var Order
     */
    protected $order = null;

    /**
     * @var Discount
     */
    protected $discount;

    /**
     * @var Delivery
     */
    protected $delivery;

    /**
     * @var array
     */
    protected $products;

    /**
     * @var array
     */
    protected $productOrder;

    public function __construct(Client $client)
    {
        $this->order = new Order();
        $this->order->setClientId($client->getId());
        return $this;
    }

    /**
     * Добавим товар
     * @param $product_id
     * @param $count
     * @return $this
     */
    public function addProduct($product_id, $count)
    {
        $product = (new ProductMapper(App::$db))->findOne(['id' => $product_id]);
        $this->productOrder[] = new ProductOrder([
            'product_id' => $product->getId(),
            'count' => $count,
        ]);
        // + проверка на остатка

        $this->products[] = $product;
        $this->afterAddProduct($product, $count);
        return $this;
    }

    /**
     * Выберем доставку
     * @param $delivery_id
     * @return $this
     */
    public function setDelivery($delivery_id)
    {
        $this->delivery = (new OrderDelivery())->getDelivery($delivery_id);
        $this->delivery->calculate($this);
        $this->order->setDeliveryId($delivery_id);
        return $this;
    }

    /**
     * Применяем скидку
     * @param $discount_id
     * @return $this
     */
    public function setDiscount($discount_id)
    {
        $this->discount = (new OrderDiscount())->getDiscount($discount_id);
        $this->discount->applyDiscount($this);
        return $this;
    }

    /**
     * Событие после добавление нового товара
     * @param $product
     * @param $count
     * @return bool
     */
    protected function afterAddProduct($product, $count): bool
    {
        $sum = $this->order->getSum() + $count * $product->getPrice();
        $this->order->setSum($sum);

        return 1;
    }

    /**
     * Итоговая стоимость
     * @return $this
     */
    public function calculate()
    {
        // Считаем итоговую сумму и кол-во товара
        (new OrderCalculate())->calculate($this);
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return Delivery
     */
    public function getDelivery(): Delivery
    {
        return $this->delivery;
    }

    /**
     * @return Discount
     */
    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    /**
     * @return array
     */
    public function getProductOrder()
    {
        return $this->productOrder;
    }
}