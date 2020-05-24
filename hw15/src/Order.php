<?php


namespace App;


use App\delivery\Delivery;

class Order
{
    private $type;

    /** @var Basket */
    private $basket;

    private $delivery;

    private $total = 0;


    /**
     * @param Basket $basket
     */
    public function setBasket(Basket $basket)
    {
        $this->basket = $basket;
        return $this;
    }

    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function addTotal($summ)
    {
        $this->total += $summ;
        return $this;
    }

    /**
     * @return Delivery
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param Delivery $delivery
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
    }

}