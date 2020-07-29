<?php


namespace Services;


interface DiscountServiceInterface
{
    public function apply(string $discountType, float $price);
}
