<?php


namespace App;


class OrderDTO
{

    public int $id;
    public string $product_name;
    public int $quantity;
    public int $total;
    public bool $processed;

    public function __construct(
        int $id,
        string $product_name,
        int $quantity,
        int $total,
        bool $processed
    )
    {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->quantity = $quantity;
        $this->total = $total;
        $this->processed = $processed;
    }
}
