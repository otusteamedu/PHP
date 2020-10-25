<?php

namespace App\Core\Delivery\AdapterDelivery;

use App\Models\ProductModel;

abstract class DeliverServiceAdapter
{
    public string $name;
    public string $description;
    abstract public function calculateDeliverPrice(ProductModel $product): float;
}