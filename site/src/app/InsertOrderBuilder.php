<?php


namespace App;
use App\InsertOrder;

/**
 * Class InsertOrderBuilder
 * @package App
 */
class InsertOrderBuilder
{
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $couponId;
    /**
     * @var
     */
    public $fullPrice;
    /**
     * @var
     */
    public $typeId;
    /**
     * @var
     */
    public $deliveryServiceId;
    /**
     * @var
     */
    public $clientId;

    /**
     * @param $name
     * @return $this
     */
    public function addName($name)
    {
        $this->name=$name;
        return $this;
    }

    /**
     * @param $couponId
     * @return $this
     */
    public function addCouponId($couponId)
    {
        $this->couponId=$couponId;
        return $this;
    }

    /**
     * @param $fullPrice
     * @return $this
     */
    public function addFullPrice($fullPrice)
    {
        $this->fullPrice=$fullPrice;
        return $this;
    }

    /**
     * @param $typeId
     * @return $this
     */
    public function addTypeId($typeId){
        $this->typeId=$typeId;
        return  $this;

    }

    /**
     * @param $deliveryServiceId
     * @return $this
     */
    public function addDeliveryServiceId($deliveryServiceId){
        $this->deliveryServiceId=$deliveryServiceId;
        return $this;
    }

    /**
     * @param $clientId
     * @return $this
     */
    public function  addClientId($clientId){
        $this->clientId=$clientId;
        return $this;
    }

    /**
     * @return \App\InsertOrder
     */
    public function build()
    {
        return new InsertOrder($this);
    }
}