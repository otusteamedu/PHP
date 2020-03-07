<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order\OrderInterface;

interface DeliveryServiceInterface
{
    public function calculateOrderDeliveryPrice(OrderInterface $order);
}