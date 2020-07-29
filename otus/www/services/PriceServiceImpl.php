<?php


namespace Services;


use Classes\Repositories\DiscountRepositoryInterface;

class PriceServiceImpl implements PriceServiceInterface
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

    public function getPriceWithDiscount(string $discountType, float $cost): float
    {
        return $this->discountService->apply($discountType, $cost);
    }

    public function getTotalPrice(int $discount, int $delivery, float $cost):float
    {
        $price = $cost;
        $deliveryPrice = $this->deliveryService->getDeliveryPrice($delivery);
        if ($deliveryPrice) {
            $price = $deliveryPrice + $cost;
        }

        return $this->discountService->apply($discount, $price);
    }

    public function getPriceWithDelivery(string $deliveryType, float $cost): float
    {
        $deliveryPrice = $this->deliveryService->getDeliveryPrice($deliveryType);
        if ($deliveryPrice) {
            return $deliveryPrice + $cost;
        }
        return $cost;
    }
}
