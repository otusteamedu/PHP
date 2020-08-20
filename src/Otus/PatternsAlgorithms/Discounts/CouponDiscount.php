<?php


namespace App\Otus\PatternsAlgorithms\Discounts;


use App\Otus\PatternsAlgorithms\Orders\Order;

/**
 * Coupon discount.
 *
 * Class CouponDiscount
 * @package App\Otus\PatternsAlgorithms\Discounts
 */
class CouponDiscount extends Discount
{
    /**
     * Amount of the discount coupon.
     *
     * @var float
     */
    protected $couponAmount;

    /**
     * CouponDiscount constructor.
     * @param float $couponAmount
     */
    public function __construct(float $couponAmount)
    {
        $this->couponAmount = $couponAmount;
    }


    /**
     * @inheritDoc
     *
     * @param Order $order
     * @return float
     */
    function getDiscountAmount(Order $order)
    {
        $this->savings = $this->couponAmount;
        return $this->savings;
    }


}