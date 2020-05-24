<?php


namespace App\price\schemes;


use App\Order;

class Discount extends SchemePrice
{
    private $discount;

    /**
     * @param mixed $discount
     */
    public function setDiscount($percent)
    {
        $this->discount = $percent/100.0;
        return $this;
    }

    public static function create(Order $order, $percent)
    {
        return (new self($order))->setDiscount($percent);
    }


    protected function execute()
    {
        $disc = $this->order->getTotal() * $this->discount;
        return $this->addTotal(-$disc);
    }

}