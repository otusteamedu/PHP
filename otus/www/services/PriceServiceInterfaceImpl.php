<?php


namespace Services;


use Classes\Repositories\DiscountRepositoryInterface;

class PriceServiceInterfaceImpl implements PriceServiceInterface
{
    private $discountService;
    private $deliveryService;

    public function __construct(
        DiscountServiceInterface $discountService,
        DeliveryServiceInterface $deliveryService
    )
    {
        $this->discountService = $discountService;
        $this->deliveryService = $deliveryService;
    }

    public function getPriceWithDiscount(int $discount, float $cost): float
    {
        return $this->discountService->apply($discount, $cost);
    }

    public function getPriceDelivery(int $delivery, float $cost): float
    {
        return $this->deliveryService->getDeliveryPrice($delivery);
    }

    public function getTotalPrice(int $discount, int $delivery, float $cost)
    {
        $price = $cost;
        $deliveryPrice = $this->deliveryService->getDeliveryPrice($delivery);
        if ($deliveryPrice) {
            $price = $deliveryPrice + $cost;
        }

        return $this->discountService->apply($discount, $price);
    }

    public function getPriceWithDelivery(int $delivery, float $cost): float
    {
        $deliveryPrice = $this->deliveryService->getDeliveryPrice($delivery);
        if ($deliveryPrice) {
            return $deliveryPrice + $cost;
        }
        return $cost;
    }
}
