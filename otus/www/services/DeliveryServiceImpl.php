<?php

namespace Services;

use Classes\Discounts\SdekDeliveryCreator;
use Classes\Models\Delivery;


class DeliveryServiceImpl implements DeliveryServiceInterface
{
    public function getDeliveryPrice(string $deliveryType)
    {
        /** @var Delivery $delivery */
        $deliveryPrice = $this->getPrice($deliveryType);
        if (!$deliveryPrice) {
            return 0;
        }

        return $deliveryPrice;
    }

    private function getPrice(string $deliveryType): float
    {
        $deliveryService = null;

        switch ($deliveryType) {
            case 'sdek':
                $deliveryService = new SdekDeliveryCreator();
                break;
        }

        if (!$deliveryService) {
            throw new \RuntimeException('undefined delivery class');
        }

        return (float) $deliveryService->getDeliveryPrice();
    }
}
