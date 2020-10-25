<?php

namespace App\Core\Delivery\AdapterDelivery;

use App\Config\DdpDeliverServiceConfig;
use App\Models\ProductModel;

class DpdDeliverService extends DeliverServiceAdapter
{
    private DpdDeliverApi $api;

    /**
     * DpdDeliverService constructor.
     * @param DpdDeliverApi $api
     */
    public function __construct(DpdDeliverApi $api)
    {
        $this->name = DdpDeliverServiceConfig::$config['name'];
        $this->description = DdpDeliverServiceConfig::$config['description'];
        $this->api = $api;
    }

    public function calculateDeliverPrice(ProductModel $product): float
    {
        return $this->api->getPriceForKg() * $product->getWeight();
    }

}