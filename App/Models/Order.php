<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\OrderMapper;
use Ozycast\App\Mappers\ProductOrderMapper;

Class Order
{
    /**
     * @var \Ozycast\App\DTO\Order
     */
    public $order;

    /**
     * @var array
     */
    public $productOrder;

    /**
     * @param OrderBuilder $builder
     *
     * @return $this
     * @throws \Exception
     */
    public function createOrder(OrderBuilder $builder)
    {
        $this->order = (new OrderMapper(App::$db))->insert($builder->getOrder());

        foreach ($builder->getProductOrder() as $productOrder) {
            $productOrder->setOrderId($this->order->getId());
            $this->productOrder[] = (new ProductOrderMapper(App::$db))->insert($productOrder);
        }

        return $this;
    }

    /**
     * В доставку, распределить товары по послыкам
     */
    public function inDelivery()
    {
        $parcel = new OrderParcel($this);
    }

}