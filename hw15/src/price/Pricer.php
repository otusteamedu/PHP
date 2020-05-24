<?php


namespace App\price;


use App\Order;
use App\price\schemes\DeliveryScheme;
use App\price\schemes\SchemePrice;

abstract class Pricer
{
    /** @var SchemePrice */
    private $schemeStart;

    /** @var DeliveryScheme */
    private $schemeDelivery;

    /** @var SchemePrice */
    private $schemeCurr;

    protected function __construct(SchemePrice $schemeStart)
    {
        $this->schemeStart = $schemeStart;
        $this->schemeCurr = $schemeStart;

        $this->schemeDelivery = new DeliveryScheme($schemeStart->getOrder());
    }

    abstract public static function create(Order $order);

    public function add(SchemePrice $schemePrice)
    {
        $schemePrice->setSchemePrev($this->schemeCurr);
        $this->schemeCurr = $schemePrice;
        return $this;
    }

    public function run()
    {
        $this->addDelivery();

        if ($this->schemeStart)
            $this->schemeStart->apply();
    }

    private function addDelivery()
    {
        if ($this->schemeDelivery)
            $this->add($this->schemeDelivery);
        return $this;
    }

}