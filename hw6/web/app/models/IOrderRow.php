<?php

namespace models;

use discounts\IDiscountRow;

interface IOrderRow
{
    public function calc();
    public function setDiscount(IDiscountRow $discount);
    public function getDiscount();
}