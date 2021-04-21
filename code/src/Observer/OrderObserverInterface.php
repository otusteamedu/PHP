<?php


namespace App\Observer;


use App\Service\Product\Order\ProductOrder;

interface OrderObserverInterface
{
    public function update(ProductOrder $order): void;
}
