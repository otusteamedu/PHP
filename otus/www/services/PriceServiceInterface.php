<?php


namespace Services;


interface PriceServiceInterface
{
    public function getPriceWithDiscount(int $discount, float $cost): float;

    public function getPriceWithDelivery(int $delivery, float $cost): float;

    public function getPriceDelivery(int $delivery, float $cost): float;

    public function getTotalPrice(int $discount, int $delivery, float $cost);
}
