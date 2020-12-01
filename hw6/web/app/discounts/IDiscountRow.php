<?php

namespace discounts;

use models\IOrderRow;

interface IDiscountRow
{
    public function calcRow(IOrderRow &$obj);
}