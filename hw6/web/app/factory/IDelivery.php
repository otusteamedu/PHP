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
     * Расчет стоимости доставки
     * @return mixed
     */
    public function calc(Order $order);
}