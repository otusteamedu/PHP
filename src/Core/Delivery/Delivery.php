<?php

namespace App\Core\Delivery;

use App\Core\Delivery\AdapterDelivery\DpdDeliverApi;
use App\Core\Delivery\AdapterDelivery\DpdDeliverService;
use App\Core\Delivery\AdapterDelivery\SberDeliverApi;
use App\Core\Delivery\AdapterDelivery\SberDeliverService;
use App\Models\OrderModel;

class Delivery
{
    public static function calculateSberDeliverServicePrice(OrderModel $order): float
    {
        $deliverServiceApi = new SberDeliverApi();
        $deliverService = new SberDeliverService($deliverServiceApi);

        return $order->calculateDeliverPrice($deliverService);
    }

    public static function calculateDpdDeliverServicePrice(OrderModel $order): float
    {
        $deliverServiceApi = new DpdDeliverApi();
        $deliverService = new DpdDeliverService($deliverServiceApi);

        return $order->calculateDeliverPrice($deliverService);
    }
}