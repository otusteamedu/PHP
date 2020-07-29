<?php


namespace Classes\Discounts;


abstract class AbstractDiscountsCreator
{
    abstract protected function getDiscount(): DiscountEntity;

    public function getDiscountValue()
    {
        $discount = $this->getDiscount();
        return $discount->getValue();
    }
}
