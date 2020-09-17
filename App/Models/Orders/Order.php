<?php


namespace Models\Orders;


class Order
{
    private ?int $id;
    private float $sum;
    private int $isPayed;

    public function __construct(?int $id, float $sum, int $isPayed = 0)
    {
        $this->id = $id;
        $this->sum = $sum;
        $this->isPayed = $isPayed;
    }

    /**
     * @return int номер заказа
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id номер заказа
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float сумма заказа
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @param float $sum сумма заказа
     */
    public function setSum(float $sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getIsPayed(): int
    {
        return $this->isPayed;
    }

    /**
     * @param int $isPayed
     */
    public function setIsPayed(int $isPayed): void
    {
        $this->isPayed = $isPayed;
    }
}