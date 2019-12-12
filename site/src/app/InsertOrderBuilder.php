<?php


namespace App;
use App\InsertOrder;

class InsertOrderBuilder
{
    public $name;
    public $couponId;
    public $fullPrice;
    public $typeId;
    public $deliveryServiceId;
    public $clientId;

    public function addName($name)
    {
        $this->name=$name;
        return $this;
    }

    public function addCouponId($couponId)
    {
        $this->couponId=$couponId;
        return $this;
    }

    public function addFullPrice($fullPrice)
    {
        $this->fullPrice=$fullPrice;
        return $this;
    }
    public function addTypeId($typeId){
        $this->typeId=$typeId;
        return  $this;

    }

    public function addDeliveryServiceId($deliveryServiceId){
        $this->deliveryServiceId=$$deliveryServiceId;
        return $this;
    }

    public function  addClientId($clientId){
        $this->clientId=$clientId;
        return $this;
    }

    public function build()
    {
        return new InsertOrder($this);
    }
}