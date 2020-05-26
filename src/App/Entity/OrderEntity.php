<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class OrderEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $number;

    /**
     * @ORM\Column(type="decimal")
     */
    private $sum;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $isPaid;

    /**
     * @param string $number
     * @param float $sum
     * @param bool $isPaid
     */
    public function __construct(string $number, float $sum, bool $isPaid)
    {
        $this->number = $number;
        $this->sum = $sum;
        $this->isPaid = $isPaid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderEntity
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return OrderEntity
     */
    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     * @return $this
     */
    public function setSum(float $sum): self
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    /**
     * @param bool $isPaid
     * @return $this
     */
    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;
        return $this;
    }
}
