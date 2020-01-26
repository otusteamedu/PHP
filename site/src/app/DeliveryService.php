<?php


namespace App;


/**
 * Class DeliveryService
 * @package App
 */
class DeliveryService
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $discountDeliveryServiceId;
    /**
     * @var
     */
    private $price;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDiscountDeliveryServiceId()
    {
        return $this->discountDeliveryServiceId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $discountDeliveryServiceId;
     */
    public function setDiscountDeliveryServiceId($discountDeliveryServiceId)
    {
        $this->discountDeliveryServiceId = $discountDeliveryServiceId;;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * DeliveryService constructor.
     * @param $id
     * @param $name
     * @param $discountDeliveryServiceId
     * @param $price
     */
    public function __construct($id, $name, $discountDeliveryServiceId, $price)

    {
        $this->id=$id;
        $this->name=$name;
        $this->discountDeliveryServiceId=$discountDeliveryServiceId;
        $this->price=$price;
    }

}