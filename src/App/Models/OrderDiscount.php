<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Interfaces\Discount;
use Ozycast\App\Mappers\DiscountMapper;

Class OrderDiscount
{
    /**
     * Получим скидку
     * @param $discount_id
     * @return Discount
     */
    public function getDiscount($discount_id): Discount
    {
        $discount = (new DiscountMapper(App::getDb()))->findOne(['id' => $discount_id]);
        $className = "Ozycast\App\Models\Discount\Discount".$discount->getCode();
        $discount = new $className;

        return $discount;
    }
}