<?php


namespace App;


class Coupon
{
    private $id;
    private $discountCouponRub;
    private $discountCouponCoefficient;

    /**
     * @return mixed
     */
    public function getDiscountCouponCoefficient()
    {
        return $this->discountCouponCoefficient;
    }

    /**
     * @return mixed
     */
    public function getDiscountCouponRub()
    {
        return $this->discountCouponRub;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $discountCouponCoefficient
     */
    public function setDiscountCouponCoefficient($discountCouponCoefficient)
    {
        $this->discountCouponCoefficient = $discountCouponCoefficient;
    }

    /**
     * @param mixed $discountCouponRub
     */
    public function setDiscountCouponRub($discountCouponRub)
    {
        $this->discountCouponRub = $discountCouponRub;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function __construct($id,$discountCouponRub,$discountCouponCoefficient)
    {
        $this->id=$id;
        $this->discountCouponRub=$discountCouponRub;
        $this->discountCouponCoefficient=$discountCouponCoefficient;

    }

}