<?php


namespace Otushw\Models;

class Order
{
    private int $id;
    private string $productName;
    private int $quantity;
    private int $total;

    public function __construct(
        int $id,
        string $productName,
        int $quantity,
        int $total
    )
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->total = $total;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }



}