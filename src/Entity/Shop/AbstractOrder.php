<?php declare(strict_types=1);

namespace Entity\Shop;

use Service\OrderNotifier\NotifierInterface;

abstract class AbstractOrder
{
    public const ORDER_TYPE_B2B = 'b2b';
    public const ORDER_TYPE_B2C = 'b2c';

    public const ORDER_STATUS_NEW = 'new';
    public const ORDER_STATUS_PAID = 'paid';
    public const ORDER_STATUS_SENT = 'sent';

    private int $id;

    private \DateTime $createdAt;

    private float $sum;

    private string $status = self::ORDER_STATUS_NEW;

    private Customer $customer;

    private ?Discount $discount;

    private NotifierInterface $notifier;

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
        return $this->sum;
    }

    public function setSum(float $sum): void
    {
        $this->sum = $sum;
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

    abstract public function getType(): string;
}
