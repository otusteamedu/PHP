<?php

namespace App\Entity;

use App\EntityInterface\IDeliveryService;
use App\EntityInterface\IDiscount;
use App\EntityInterface\IOrderCalculator;
use App\EntityInterface\IProduct;

class OrderCalculator implements IOrderCalculator
{
    private OrderContents $orderContents;
    private float $totalPrice = .0;

    /**
     * OrderCalculator constructor.
     * @param OrderContents $orderContents
     */
    public function __construct(OrderContents $orderContents)
    {
        $this->orderContents = $orderContents;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        $this->calculate();
        return $this->totalPrice;
    }

    private function calculate()
    {
        $productsPrice = array_sum(
            array_map(
                fn(IProduct $product): float => $product->getPrice(),
                $this->orderContents->getProducts()
            )
        );
        $deliveriesPrice = array_sum(
            array_map(
                fn(IDeliveryService $service): float => $service->getPrice(),
                $this->orderContents->getDeliveryServices()
            )
        );
        $priceSum = $productsPrice + $deliveriesPrice;
        $discountsSum = array_sum(
            array_map(
                fn(IDiscount $discount) => $discount->getValue($priceSum),
                $this->orderContents->getDiscounts()
            )
        );
        $this->totalPrice = $priceSum - $discountsSum;
        if ($this->totalPrice < 0) {
            $this->totalPrice = 0;
        }
    }
}