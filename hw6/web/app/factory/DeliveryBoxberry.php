<?php

namespace factory;

use models\Order;

class DeliveryBoxberry implements IDelivery
{
    /**
     * Минимальная цена доставки (руб)
     */
    const MIN_COST = 10;

    /**
     * @inheritDoc
     */
    public function calc(Order $order)
    {
        $res = 0;
        $products = $order->getProducts();
        foreach ($products as $item) {
            $res += $item['count'] * self::MIN_COST;
        }
        return $res;
    }
}