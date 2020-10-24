<?php

namespace App\Models;

use App\Core\Delivery\AdapterDelivery\DeliverServiceAdapter;
use App\Core\Delivery\AdapterDelivery\DpdDeliverService;

class OrderModel
{
    private array $products;

    public function calculateDeliverPrice(DeliverServiceAdapter $deliverService): float
    {
        $deliverPrice = 0.0;
        foreach ($this->products as $product)
        {
            $deliverPrice += $deliverService->calculateDeliverPrice($product);
        }
        return $deliverPrice;
    }
}