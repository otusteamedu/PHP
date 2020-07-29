<?php


namespace Classes\Discounts;


class LogisticDiscount implements DiscountEntity
{

    const DEFAULT_DISCOUNT = 100;

    public function getValue()
    {
       return self::DEFAULT_DISCOUNT;
    }
}

