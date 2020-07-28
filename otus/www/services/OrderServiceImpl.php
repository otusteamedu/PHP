<?php

namespace Services;

use Classes\Dto\OrderDto;
use Classes\Models\Order;
use Classes\Models\OrderClientPivot;
use Classes\Models\OrderStatus;
use Classes\Repositories\DeliveryRepositoryInterface;
use Classes\Repositories\DiscountRepositoryInterface;
use Classes\Repositories\OrderClientRepositoryInterface;
use Classes\Repositories\OrderRepositoryInterface;


class OrderServiceImpl implements OrderServiceInterface
{

    private $orderRepository;
    private $deliveryRepository;
    private $discountRepository;
    private $priceService;
    private $orderClientRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        DeliveryRepositoryInterface $deliveryRepository,
        DiscountRepositoryInterface $discountRepository,
        PriceServiceInterface $priceService,
        OrderClientRepositoryInterface $orderClientRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->discountRepository = $discountRepository;
        $this->priceService = $priceService;
        $this->orderClientRepository = $orderClientRepository;
    }

    public function registerOrder(OrderDto $orderDto)
    {
        $delivery = $this->deliveryRepository->getDeliveryById($orderDto->delivery);
        $discount = $this->discountRepository->getDiscountById($orderDto->discount);
        $finalPrice = $this->getFinalPrice($orderDto);
        $number = $this->getOrderNumber();

        $orderEntity = new Order();
        $orderEntity->setNumber($number);
        $orderEntity->setStatus(OrderStatus::NEW_ORDER);
        $orderEntity->setCost($finalPrice);
        $orderEntity->setDelivery($delivery);
        $orderEntity->setDiscount($discount);
        $orderEntity->setProducts($orderDto->products);

        $newOrderId = $this->orderRepository->saveOrder($orderEntity);

        $orderClientPivot = new OrderClientPivot();
        $orderClientPivot->setClientId($orderDto->userId);
        $orderClientPivot->setOrderId($newOrderId);
        $this->orderClientRepository->save($orderClientPivot);
    }

    public function deleteOrder(int $orderId)
    {
        $this->orderRepository->deleteOrder($orderId);
    }

    private function getFinalPrice(OrderDto $orderDto)
    {

        if ($orderDto->discount && $orderDto->delivery) {
            return $this->priceService->getTotalPrice($orderDto->discount,$orderDto->delivery, $orderDto->cost);
        }

        if ($orderDto->discount && !$orderDto->delivery) {
            return $this->priceService->getPriceWithDiscount($orderDto->discount, $orderDto->cost);
        }

        if (!$orderDto->discount && $orderDto->delivery) {
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
