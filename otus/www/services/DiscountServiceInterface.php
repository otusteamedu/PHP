<?php


namespace Services;


interface DiscountServiceInterface
{

    public function apply(int $discountId, float $price);
}
