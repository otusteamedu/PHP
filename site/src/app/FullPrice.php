<?php


namespace App;
use App\FullPriceBuilder;

class FullPrice
{
   public $productPrice;
    public $orderPrice;
    public $deliveryPrice;
    public  $discountCouponRub;
    public $discountCouponCoefficient;

    public function __construct(FullPriceBuilder $builder)
    {
        $this->discountCouponCoefficient=$builder->discountCouponCoefficient;
        $this->discountCouponRub=$builder->discountCouponRub;
        $this->deliveryPrice=$builder->deliveryPrice;
        $this->orderPrice=$builder->orderPrice;
        $this->productPrice=$builder->productPrice;
    }


}