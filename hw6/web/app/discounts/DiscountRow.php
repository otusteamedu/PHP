<?php

namespace discounts;
use models\IOrderRow;

/**
 * Class DiscountRow
 *
 * Скидка суммой для строки
 *
 * @package discounts
 */

class DiscountRow implements IDiscountRow
{
    private $discount;


    /**
     * @param $discount Размер скидки
     */
    public function __constructor($discount) {
        $this->discount = $discount;
    }


    /**
     * @param IOrderRow $obj
     *
     * @return mixed
     */
    public function calcRow(IOrderRow &$obj)
    {
        $obj->total = $obj->total - $this->discount;
        return $this->discount;
    }
}