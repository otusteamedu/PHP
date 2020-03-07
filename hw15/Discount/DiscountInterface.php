<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order\OrderInterface;

interface DiscountInterface
{
    public function calculateOrderPrice(OrderInterface $order);
}