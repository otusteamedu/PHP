<?php
/**
 * Скидка суммой на весь заказ
 */

namespace discounts;

use models\Order;

class DiscountDoc implements IDiscount
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var float
     */
    private $val;


    /**
     * @param Order $order заказ
     * @param float $val   размер скидки
     */
    public function __constructor(Order $order, float $val)
    {
        $this->order = $order;
        $this->val   = $val;
    }


    /**
     * Расчет скидки на сумму документа
     *
     * @param Order $obj
     *
     * @return float|int
     */
    public function calc(&$obj)
    {
        $obj->totalCost = $obj->totalCost - $this->val;

        return $this->val;
    }
}