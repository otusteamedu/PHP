<?php

namespace Services;

use Classes\Dto\OrderDto;
use Classes\Models\Order;
use Classes\Models\OrderClientPivot;
use Classes\Models\OrderStatus;
use Classes\Repositories\DeliveryRepositoryInterface;
use Classes\Repositories\OrderClientRepositoryInterface;
use Classes\Repositories\OrderRepositoryInterface;


class OrderServiceImpl implements OrderServiceInterface
{

    private $orderRepository;
    private $deliveryRepository;
    private $priceService;
    private $orderClientRepository;
    private $discountService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        DeliveryRepositoryInterface $deliveryRepository,
        PriceServiceInterface $priceService,
        DiscountServiceInterface $discountService,
        OrderClientRepositoryInterface $orderClientRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->priceService = $priceService;
        $this->orderClientRepository = $orderClientRepository;
        $this->discountService = $discountService;
    }

    public function createOrder(OrderDto $orderDto)
    {
        $delivery = $this->deliveryRepository->getDeliveryByType($orderDto->delivery);
        $finalPrice = $this->getFinalPrice($orderDto);
        $number = $this->getOrderNumber();

        $orderEntity = new Order();
        $orderEntity->setNumber($number);
        $orderEntity->setStatus(OrderStatus::NEW_ORDER);
        $orderEntity->setCost($finalPrice);
        $orderEntity->setDelivery($delivery);
        $orderEntity->setProducts($orderDto->products);

        $newOrderId = $this->orderRepository->saveOrder($orderEntity);

        $orderClientPivot = new OrderClientPivot();
        $orderClientPivot->setClientId($orderDto->userId);
        $orderClientPivot->setOrderId($newOrderId);
        $this->orderClientRepository->save($orderClientPivot);

        return $newOrderId;
    }

    public function deleteOrder(int $orderId)
    {
        $this->orderRepository->deleteOrder($orderId);
    }

    private function getFinalPrice(OrderDto $orderDto)
    {

        if ($orderDto->discountType && $orderDto->delivery) {
            return $this->priceService->getTotalPrice($orderDto->discountType,$orderDto->delivery, $orderDto->cost);
        }

        if ($orderDto->discountType && !$orderDto->delivery) {
            return $this->priceService->getPriceWithDiscount($orderDto->discountType, $orderDto->cost);
        }

        if (!$orderDto->discountType && $orderDto->delivery) {
            return $this->priceService->getPriceWithDelivery($orderDto->delivery, $orderDto->cost);
        }

        return $orderDto->cost;
    }

    private function getOrderNumber()
    {
        $date = new \DateTime();
        /** @noinspection PhpUnhandledExceptionInspection */
        return random_int(100, 1000) + $date->getTimestamp();
    }
}
