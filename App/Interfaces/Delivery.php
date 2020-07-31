<?php
namespace Ozycast\App\Interfaces;

use Ozycast\App\Models\OrderBuilder;

interface Delivery
{
    /**
     * Подсчет цены доставки
     * @param OrderBuilder $builder
     * @return bool
     */
    public function calculate(OrderBuilder $builder);

    /**
     * Вернуть цену доставки
     * @return int
     */
    public function getSum(): int;
}