<?php
/**
 * Скидка на весь заказ в процентах
 */
namespace discounts;

use models\Order;

class DiscountDocPercent implements IDiscount
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var float
     */
    private $percent;
    private $val;


    /**
     * @param Order $order заказ
     * @param float $percent скидка в процентах
     */
    public function __constructor(Order $order, float $percent){
        $this->order = $order;
        $this->percent = $percent;
    }

    /**
     * Расчет скидки в процентах на сумму документа
     * @param Order $obj
     *
     * @return float|int
     */
    public function calc(&$obj)
    {
        $this->val = ($obj->totalCost * $this->percent) / 100;
        $obj->totalCost = $obj->totalCost - $this->val;
        return $this->val;
    }
}