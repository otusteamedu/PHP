<?php declare(strict_types=1);

namespace Entity\Shop;

use Service\OrderNotifier\NotifierInterface;
use SplObserver;

abstract class AbstractOrder implements \SplSubject
{
    public const ORDER_TYPE_B2B = 'b2b';
    public const ORDER_TYPE_B2C = 'b2c';

    public const ORDER_STATUS_NEW = 'new';
    public const ORDER_STATUS_PAID = 'paid';
    public const ORDER_STATUS_SENT = 'sent';

    private int $id;

    private \DateTime $createdAt;

    private string $status = self::ORDER_STATUS_NEW;

    private Customer $customer;

    private ?Discount $discount = null;

    private NotifierInterface $notifier;

    private \SplObjectStorage $observers;

    private array $orderProducts = [];

    private array $shipments = [];

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getSum(): float
    {
        $orderSum = 0;
        foreach ($this->getOrderProducts() as $product) {
            $orderSum += $product->getSum();
        }

        if ($this->getDiscount() !== null) {
            $orderSum = $orderSum - $orderSum * $this->getDiscount() / 100;
        }

        $shippingSum = 0;
        foreach ($this->getShipments() as $shipment) {
            $shippingSum += $shipment->getSum();
        }

        return $orderSum + $shippingSum;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): void
    {
        $this->discount = $discount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        if ($status !== $this->status) {
            $this->notifier->notify($this->customer);
        }
        $this->status = $status;
    }

    public function getNotifier(): NotifierInterface
    {
        return $this->notifier;
    }

    public function setNotifier(NotifierInterface $notifier): void
    {
        $this->notifier = $notifier;
    }

    /**
     * @return array|OrderProduct[]
     */
    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    public function setOrderProducts(array $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
    }

    /**
     * @return array|Shipment[]
     */
    public function getShipments(): array
    {
        return $this->shipments;
    }

    public function setShipments(array $shipments): void
    {
        $this->shipments = $shipments;
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        /** @var SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    abstract public function getType(): string;
}
