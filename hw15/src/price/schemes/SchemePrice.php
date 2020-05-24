<?php


namespace App\price\schemes;


use App\Order;

abstract class SchemePrice
{
    protected $order;
    /** @var SchemePrice */
    protected $schemePrev;

    /** @var SchemePrice */
    protected $schemeNext;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param SchemePrice $schemePrev
     */
    public function setSchemePrev(SchemePrice $schemePrev)
    {
        $schemePrev->schemeNext = $this;
        $this->schemePrev = $schemePrev;
        return $this;
    }

    abstract protected function execute();

    public function apply()
    {
        $this->execute();
        if ($this->schemeNext)
            $this->schemeNext->apply();
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    protected function addTotal($summ)
    {
        $this->order->addTotal($summ);
        return $this;
    }

}