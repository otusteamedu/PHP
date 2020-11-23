<?php
/**
 * Скидка на весь заказ в процентах
 */
namespace discounts;

use models\Order;

class DisTotalPercent
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var float
     */
    private $percent;


    /**
     * @param Order $order заказ
     * @param float $percent скидка в процентах
     */
    public function __constructor(Order $order, float $percent){
        $this->order = $order;
        $this->percent = $percent;
        $this->do();
    }

    private function do(){
        $this->order->setDiscount($this->percent);
    }


    /**
     * Получить измененный заказ
     * @return Order
     */
    public function getOrder(){
        return $this->order;
    }
}