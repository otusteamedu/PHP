<?php

namespace App\Core\Delivery\AdapterDelivery;

use App\Config\SberDeliverServiceConfig;
use App\Models\ProductModel;

class SberDeliverService extends DeliverServiceAdapter
{

    private SberDeliverApi $api;

    /**
     * DpdDeliverService constructor.
     * @param SberDeliverApi $api
     */
    public function __construct(SberDeliverApi $api)
    {
        $this->name = SberDeliverServiceConfig::$config['name'];
        $this->description = SberDeliverServiceConfig::$config['description'];
        $this->api = $api;
    }

    public function calculateDeliverPrice(ProductModel $product): float
    {
        return $this->api->getPriceForCbm() * $product->getVolume();
    }


}