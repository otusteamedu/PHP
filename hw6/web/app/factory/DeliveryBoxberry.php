<?php

namespace factory;

use models\Order;

class DeliveryBoxberry implements IDelivery
{
    /**
     * Минимальная цена доставки (руб)
     */
    const MIN_COST = 10;
    private $order;

    public function __construct(Order $order){
        $this->order = $order;
    }

    /**
     * @inheritDoc
     */
    public function calc()
    {
        $res = 0;
        $products = $this->order->getProducts();
        foreach ($products as $item) {
            $res += $item['count'] * self::MIN_COST;
        }
        return $res;
    }
}