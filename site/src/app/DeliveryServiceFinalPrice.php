<?php


namespace App;


class DeliveryServiceFinalPrice
{
private $deliveryServiceId;
private $deliveryServicePrice;

    /**
     * @return mixed
     */
    public function getDeliveryServiceId()
    {
        return $this->deliveryServiceId;
    }

    /**
     * @param mixed $deliveryServiceId
     */
    public function setDeliveryServiceId($deliveryServiceId)
    {
        $this->deliveryServiceId = $deliveryServiceId;
    }

    /**
     * @return mixed
     */
    public function getDeliveryServicePrice()
    {
        return $this->deliveryServicePrice;
    }

    /**
     * @param mixed $productsPrice
     */
    public function setProductsPrice($deliveryServicePrice)
    {
        $this->deliveryServicePrice = $deliveryServicePrice;
    }

    public function __construct($deliveryServiceId ,$deliveryServicePrice)
    {
        $this->deliveryServiceId=$deliveryServiceId;
        $this->deliveryServicePrice=$deliveryServicePrice;
    }

}