<?php

namespace discounts;

use models\IOrderRow;

class DiscountPercentRow implements IDiscountRow
{
    private $percent;


    /**
     * @param $precent размер скидки в процентах
     */
    public function __constructor($precent){
        $this->percent = $precent;
    }


    /**
     * @param IOrderRow $obj
     *
     * @return float|int
     */
    public function calcRow(IOrderRow &$obj)
    {
        $val = ($obj->total * $this->percent) / 100;
        $obj->total = $obj->total - $val;
        return $val;
    }
}