<?php

namespace App\Core\Delivery\AdapterDelivery;

use App\Config\SberDeliverServiceConfig;

class SberDeliverApi
{
    private string $apiUrl;
    private string $token;
    private float $priceForCbm;

    /**
     * SberDeliverApi constructor.
     */
    public function __construct()
    {
        $this->apiUrl = SberDeliverServiceConfig::$config['apiUrl'];
        $this->token = SberDeliverServiceConfig::$config['token'];
        $this->priceForCbm = $this->getPriceForCbm();
    }

    public function getPriceForCbm(): float
    {
        if (isset($this->priceForCbm)) {
            return $this->priceForCbm;
        }

        //..send get to API Dpd
        $this->priceForCbm = $resultApi;
        return $this->priceForCbm;
    }
}