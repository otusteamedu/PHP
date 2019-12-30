<?php


namespace App;
use App\FullPrice;


class FullPriceBuilder
{
    public $productPrice;
    public $orderPrice;
    public $deliveryPrice;
    public $discountCouponRub;
    public $discountCouponCoefficient;

    public function addProductPrice($product_price)
    {
        foreach ($product_price as $key => $value) {
            $this->productPrice += $value;
        }
        return $this;
    }

    public function addDiscountCouponRub($discountCouponRub)
    {
        $this->discountCouponRub=$discountCouponRub;
        return $this;
    }

    public function addDiscountCouponCoefficient($discountCouponCoefficient)
    {
        $this->discountCouponCoefficient=$discountCouponCoefficient;
        return $this;
    }
    public  function addDeliveryPrice($delivery){
        $this->deliveryPrice=$delivery;
        return $this;
    }

    public function countPrice()
    {
        $this->orderPrice=$this->productPrice+$this->deliveryPrice-$this->discountCouponRub*$this->discountCouponCoefficient;
        return $this;
    }

    public function build()
    {
        return new FullPrice($this);
    }


}