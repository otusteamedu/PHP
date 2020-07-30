<?php


namespace Classes\Discounts;


class LogisticDiscountCreator extends AbstractDiscountsCreator
{

    protected function getDiscount(): DiscountEntity
    {
        return new LogisticDiscount();
    }
}

