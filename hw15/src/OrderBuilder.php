<?php


namespace App;


use App\package\Packager;
use App\price\CustomPricer;
use App\price\Pricer;

class OrderBuilder
{
    /** @var Order */
    private $order;
    /** @var Pricer */
    private $pricer;


    /**
     * OrderBuilder constructor.
     * @param Order $order
     */
    private function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * @param Order $order
     * @return OrderBuilder
     */
    public static function create($order)
    {
        return new self($order);
    }

    /**
     * @param Pricer $pricer
     * @return $this
     */
    public function setPricer($pricer)
    {
        $this->pricer = $pricer;
        return $this;
    }

    public function build()
    {
        $this->buildPrice();
        $this->packaging();
    }

    private function buildPrice()
    {
        if ($this->pricer)
            $this->pricer->run();

        return $this;
    }

    /**
     * @param Order $order
     */
    private function packaging()
    {
        $packager = new Packager();
        foreach ($this->order->getBasket()->getProducts() as $good)
        {
            $package = $packager->getPackage($good->getPackageID());
            //Do something

        }
        return $this;
    }

}