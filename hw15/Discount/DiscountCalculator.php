<?php

declare(strict_types=1);

namespace App\Discount;

class DiscountCalculator
{
    /**
     * @var DiscountInterface
     */
    private $discount;

    public function setDiscount(DiscountInterface $discount)
    {
        $this->discount = $discount;
    }

    public function calculateDiscount($order): array
    {
        $this->discount->calculateOrderPrice($order);
    }
}