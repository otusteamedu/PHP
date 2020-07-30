<?php


namespace Services;


interface PriceServiceInterface
{
    public function getPriceWithDiscount(string $discountType, float $cost): float;

    public function getPriceWithDelivery(string $deliveryType, float $cost): float;

    public function getTotalPrice(int $discount, int $delivery, float $cost): float;
}
