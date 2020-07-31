<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\DeliveryMapper;

Class OrderDelivery
{
    /**
     * Получим доставщика
     * @param int $delivery_id
     * @return \Ozycast\App\Core\DTO|null
     */
    public function getDelivery(int $delivery_id)
    {
        $delivery = (new DeliveryMapper(App::$db))->findOne(['id' => $delivery_id]);
        $className = "Ozycast\App\Models\Delivery\Delivery".$delivery->getCode();
        $delivery = new $className;

        return $delivery;
    }
}