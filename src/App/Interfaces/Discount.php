<?php
namespace Ozycast\App\Interfaces;

use Ozycast\App\Models\OrderBuilder;

interface Discount
{
    /**
     * Применить скидку
     * @param OrderBuilder $builder
     * @return bool
     */
    public function applyDiscount(OrderBuilder $builder);

    /**
     * Получить сумму скидки
     * @return int
     */
    public function getDiscount(): int;
}