<?php

declare(strict_types=1);

namespace App\Discount;

class DeliveryCalculator
{
    /**
     * @var DeliveryServiceInterface
     */
    private $deliveryService;

    public function setDeliveryService(DeliveryServiceInterface $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function calculateDelivery($order): array
    {
        $this->deliveryService->calculateOrderDeliveryPrice($order);
    }
}