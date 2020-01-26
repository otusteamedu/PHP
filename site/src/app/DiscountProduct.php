<?php


namespace App;


/**
 * Class DiscountProduct
 * @package App
 */
class DiscountProduct
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $discountDeliveryRub;
    /**
     * @var
     */
    private $discountDeliveryCoefficient;

    /**
     * @return mixed
     */
    public function getDiscountDeliveryRub()
    {
        return $this->discountDeliveryRub;
    }

    /**
     * @return mixed
     */
    public function getDiscountDeliveryCoefficient()
    {
        return $this->discountDeliveryCoefficient;
    }

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
     * @param mixed $discountDeliveryCoefficient
     */
    public function setDiscountDeliveryCoefficient($discountDeliveryCoefficient)
    {
        $this->discountDeliveryCoefficient = $discountDeliveryCoefficient;
    }

    /**
     * @param mixed $discountDeliveryRub
     */
    public function setDiscountDeliveryRub($discountDeliveryRub)
    {
        $this->discountDeliveryRub = $discountDeliveryRub;
    }

    /**
     * DiscountProduct constructor.
     * @param $id
     * @param $discountDeliveryRub
     * @param $discountDeliveryCoefficient
     */
    public  function __construct($id, $discountDeliveryRub, $discountDeliveryCoefficient)
    {
        $this->id=$id;
        $this->discountDeliveryRub=$discountDeliveryRub;
        $this->discountDeliveryCoefficient=$discountDeliveryCoefficient;
    }


}