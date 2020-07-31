<?php

namespace Ozycast\App\Models\Delivery;

use Ozycast\App\Interfaces\Delivery;
use Ozycast\App\Models\OrderBuilder;

class DeliveryAshot implements Delivery
{
    protected $sum = 0;

    public function calculate(OrderBuilder $builder)
    {
        // Считаем стоимость доставки
        $this->sum = 20;
        return 1;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }
}