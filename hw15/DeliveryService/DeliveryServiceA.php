<?php

declare(strict_types=1);

namespace App\DeliveryService;

use App\Discount\DeliveryServiceInterface;
use App\Order\OrderInterface;

class DeliveryServiceA implements DeliveryServiceInterface
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function calculateOrderDeliveryPrice(OrderInterface $order)
    {
        // пересчет цены доставки для сервиса A
    }
}