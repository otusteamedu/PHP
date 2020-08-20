<?php


namespace App\Otus\PatternsAlgorithms\Discounts;

use App\Otus\PatternsAlgorithms\Orders\Order;

/**
 * Percentage discount.
 *
 * Class PercentageDiscount
 * @package App\Otus\PatternsAlgorithms\Discounts
 */
class PercentageDiscount extends Discount
{
    /**
     * Discount percentage.
     *
     * @var float
     */
    private $discountPercentage;

    /**
     * Discount percentage constructor.
     *
     * @param float $discountPercentage
     */
    public function __construct(float $discountPercentage)
    {
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @inheritDoc
     *
     * @param Order $order
     * @return float|int
     */
    function getDiscountAmount(Order $order)
    {
        $this->savings = $order->getSubtotalBeforeDiscounts() * $this->discountPercentage;
        return $this->savings;
    }

}