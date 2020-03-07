<?php

declare(strict_types=1);

namespace App\Order;

class AbstractOrder implements OrderInterface
{
    public const TYPE = 'b2b';

    protected $id;

    protected $items;

    protected $deliverService;

    protected $totalPrice;

    public function __construct(array $data)
    {
        $this->items = $data['items'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems($items): array
    {
        $this->items = $items;
    }

    public function getDeliveryService()
    {
        return $this->deliverService;
    }

    public function setDeliveryService($service)
    {
        $this->deliverService = $service;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($price)
    {
        $this->totalPrice = $price;
    }

    public function save()
    {
        // сохранение в БД
    }
}