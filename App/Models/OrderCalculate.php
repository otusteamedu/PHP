<?php

namespace Ozycast\App\Models;

use Ozycast\App\Models\OrderBuilder;

class OrderCalculate
{

    /**
     * Считаем сумму заказа с учетом доставки и скидки
     * @param \Ozycast\App\Models\OrderBuilder $builder
     */
    public function calculate(OrderBuilder $builder)
    {
        // + считаем стоимость заказа с учетом доставки и скидок
        $delivery = $builder->getDelivery();
        $order = $builder->getOrder();
        $discount = $builder->getDiscount();

        $sum = $order->getSum() + $delivery->getSum() - $discount->getDiscount();
        $order->setSum($sum);
    }
}