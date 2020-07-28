<?php


namespace Services;


use Classes\Models\Delivery;
use Classes\Repositories\DeliveryRepositoryInterface;

class DeliveryServiceInterfaceImpl implements DeliveryServiceInterface
{
    private $deliveryRepository;

    public function __construct(DeliveryRepositoryInterface $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }
    public function getDeliveryPrice(int $delivery)
    {
        /** @var Delivery $delivery */
        $delivery = $this->deliveryRepository->getDeliveryById($delivery);
        if (!$delivery) {
            return null;
        }

        return $delivery->getCost();
    }
}
