<?php

namespace App\Core\Delivery\AdapterDelivery;

use App\Config\DdpDeliverServiceConfig;

class DpdDeliverApi
{
    private string $apiUrl;
    private string $apiKey;
    private float $priceForKg;

    /**
     * SberDeliverApi constructor.
     */
    public function __construct()
    {
        $this->apiUrl = DdpDeliverServiceConfig::$config['apiUrl'];
        $this->apiKey = DdpDeliverServiceConfig::$config['apiKey'];
        $this->priceForKg = $this->getPriceForKg();
    }

    public function getPriceForKg(): float
    {
        if (isset($this->priceForKg)) {
            return $this->priceForKg;
        }

        //..send get to API Dpd
        $this->priceForKg = $resultApi;
        return $this->priceForKg;
    }
}