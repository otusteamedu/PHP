<?php


namespace Otus\Model;


use RedBeanPHP\R;

class Order
{
    private $tableName = 'orders';

    private int $id;
    private int $createdAt;
    private int $updateAt;
    private string $orderNumber;
    private int $sum;
    private int $cardNumber;
    private string $cardHolder;
    private int $cvv;
    private $cardExpiration;
    private bool $isPaid;
    private array $additionalData;

    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdateAt(): int
    {
        return $this->updateAt;
    }

    public function setUpdateAt(int $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @param int $sum
     */
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    public function setCardNumber(int $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    public function getCvv(): int
    {
        return $this->cvv;
    }

    public function setCvv(int $cvv): void
    {
        $this->cvv = $cvv;
    }

    public function getCardExpiration()
    {
        return $this->cardExpiration;
    }

    public function setCardExpiration($cardExpiration): void
    {
        $this->cardExpiration = $cardExpiration;
    }


    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function setCardHolder(string $cardHolder): void
    {
        $this->cardHolder = $cardHolder;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function setAdditionalData(array $additionalData): void
    {
        $this->additionalData = $additionalData;
    }

    /**
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function save()
    {
        $order = R::dispense($this->tableName);
        $order->card_number = $this->cardNumber;
        $order->card_holder = $this->cardHolder;
        $order->card_expiration = $this->cardExpiration;
        $order->cvv = $this->cvv;
        $order->order_number = $this->orderNumber;
        $order->sum = $this->sum;

        $result = R::store($order);
        return $result;
    }
}
