<?php

declare(strict_types=1);

namespace App\Entity;

use App\DeliveryService\DeliveryServiceResolver;
use App\Discount\DeliveryCalculator;
use App\Discount\DiscountCalculator;
use App\Discount\DiscountsResolver;
use App\Order\OrderFactory;
use Exception;


class ClientCode
{
    /**
     * @param array $data
     * @param DiscountsResolver $discountsResolver
     * @param DiscountCalculator $discountCalculator
     * @throws Exception
     */
    public function createOrder(
        array $data,
        DiscountsResolver $discountsResolver,
        DiscountCalculator $discountCalculator,
        DeliveryServiceResolver $deliveryServiceResolver,
        DeliveryCalculator $deliveryCalculator
    ) {
        $order = OrderFactory::getOrder($data);

        $discounts = $discountsResolver->getDiscounts();
        foreach ($discounts as $discount) {
            $discountCalculator->setDiscount($discount);
            $discountCalculator->calculateDiscount($order);
        }

        $deliveryServices = $deliveryServiceResolver->getDeliveryServices();
        foreach ($deliveryServices as $deliveryService) {
            $deliveryCalculator->setDeliveryService($deliveryService);
            $deliveryCalculator->calculateDelivery($order);
        }

        $order->save();
    }
}