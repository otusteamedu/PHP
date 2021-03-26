<?php


namespace Otushw\DTOs;


class OrderDTO
{

    public int $id;
    public string $productName;
    public int $quantity;
    public int $total;

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

    public function __toString()
    {
        return "Name: $this->productName, Quantity: $this->quantity, Total: $this->total";
    }
}