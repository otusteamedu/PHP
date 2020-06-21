<?php

namespace Ozycast\App\Models\Discount;

use Ozycast\App\Interfaces\Discount;
use Ozycast\App\Models\OrderBuilder;

class DiscountFreeDelivery implements Discount
{
    protected $discount = 0;

    public function applyDiscount(OrderBuilder $builder)
    {
        // + проверям доступна ли скидка на товары и действительно ли она
        $delivery = $builder->getDelivery();
        $this->discount = $delivery->getSum();
        return 1;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }
}