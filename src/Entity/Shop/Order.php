<?php declare(strict_types=1);

namespace Entity\Shop;

class Order implements \JsonSerializable
{
    private int $id;

    private \DateTime $createdAt;

    private float $sum;

    private Customer $customer;

    private \Closure $customerReference;

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
        if (!isset($this->customer)) {
            $reference = $this->customerReference;
            $this->customer = $reference();
        }

        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function setCustomerReference(\Closure $customerReference): void
    {
        $this->customerReference = $customerReference;
    }

    public function handleArray(array $order): void
    {
        if (isset($order['created_at'])) {
            $this->setCreatedAt(new \DateTime($order['created_at']));
        }
        if (isset($order['sum'])) {
            $this->setSum($order['sum']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'created_at' => $this->getCreatedAt()->format(DATE_ISO8601),
            'sum' => $this->getSum(),
            'customer' => $this->getCustomer()
        ];
    }
}
