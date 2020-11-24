<?php

namespace factory;
use models\Order;

/**
 * Interface IDelivery - служба доставки
 *
 * @author PEtr Ivanov (petr.yrs@gmail.com)
 * @package factory
 */
interface IDelivery
{
    /**
     * IDelivery constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order);
    /**
     * Расчет стоимости доставки
     * @return mixed
     */
    public function calc();
}