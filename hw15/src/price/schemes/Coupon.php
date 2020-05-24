<?php


namespace App\price\schemes;


use App\Order;

class Coupon extends SchemePrice
{
    private $value = 0;

    public static function create(Order $order, $value)
    {
        $inst = new static($order);
        $inst->value = $value;
        return $inst;
    }

    protected function execute()
    {
        $this->addTotal(-$this->value);
    }
}