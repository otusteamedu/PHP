<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order\OrderInterface;

class UserDiscount implements DiscountInterface
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function calculateOrderPrice(OrderInterface $order)
    {
        // пересчет цены заказа
    }
}