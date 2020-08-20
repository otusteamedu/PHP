<?php


namespace App\Otus\PatternsAlgorithms\Discounts;


use App\Otus\PatternsAlgorithms\Orders\Order;

/**
 * Discount to be applied to the order.
 *
 * Class Discount
 * @package App\Otus\PatternsAlgorithms\Discounts
 */
abstract class Discount
{
    /**
     * Name of the discount.
     *
     * @var string
     */
    protected $name;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Savings in currency when this discount is applied.
     *
     * @var float
     */
    protected $savings;


    /**
     * Returns discount amount in currency.
     *
     * @param Order $order
     * @return float
     */
    abstract function getDiscountAmount(Order $order);


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getSavings()
    {
        return round($this->savings,2);
    }

    function __toString()
    {
        return $this->name . ' - $' . $this->getSavings();
    }

}