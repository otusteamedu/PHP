<?php


namespace App;
use App\FullPriceBuilder;

/**
 * Class FullPrice
 * @package App
 */
class FullPrice
{
    /**
     * @var
     */
    public $productPrice;
    /**
     * @var
     */
    public $orderPrice;
    /**
     * @var
     */
    public $deliveryPrice;
    /**
     * @var
     */
    public  $discountCouponRub;
    /**
     * @var
     */
    public $discountCouponCoefficient;

    /**
     * FullPrice constructor.
     * @param \App\FullPriceBuilder $builder
     */
    public function __construct(FullPriceBuilder $builder)
    {
        $this->discountCouponCoefficient=$builder->discountCouponCoefficient;
        $this->discountCouponRub=$builder->discountCouponRub;
        $this->deliveryPrice=$builder->deliveryPrice;
        $this->orderPrice=$builder->orderPrice;
        $this->productPrice=$builder->productPrice;
    }


}