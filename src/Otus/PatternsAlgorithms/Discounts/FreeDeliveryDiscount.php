<?php


namespace App\Otus\PatternsAlgorithms\Discounts;


use App\Otus\PatternsAlgorithms\Orders\Order;

/**
 * Free delivery discount.
 *
 * Class FreeDeliveryDiscount
 * @package App\Otus\PatternsAlgorithms\Discounts
 */
class FreeDeliveryDiscount extends Discount
{

    /**
     * @inheritDoc
     *
     * @param Order $order
     * @return float
     */
    function getDiscountAmount(Order $order)
    {
        $this->savings = $order->getShipmentSubtotal();
        return $this->savings;
    }

}