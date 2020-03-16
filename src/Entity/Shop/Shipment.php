<?php declare(strict_types=1);

namespace Entity\Shop;

class Shipment
{
    private int $id;

    private ShippingSystem $shippingSystem;

    private AbstractOrder $order;

    private \DateTime $date;

    private float $sum;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getShippingSystem(): ShippingSystem
    {
        return $this->shippingSystem;
    }

    public function setShippingSystem(ShippingSystem $shippingSystem): void
    {
        $this->shippingSystem = $shippingSystem;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): void
    {
        $this->sum = $sum;
    }

    public function getOrder(): AbstractOrder
    {
        return $this->order;
    }

    public function setOrder(AbstractOrder $order): void
    {
        $this->order = $order;
    }
}
