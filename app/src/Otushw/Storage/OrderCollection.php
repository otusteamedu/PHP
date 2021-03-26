<?php


namespace Otushw\Storage;

use Iterator;
use Otushw\Models\Order;

class OrderCollection implements Iterator
{
    private int $pointer = 0;
    private int $total = 0;
    private array $objects = [];
    private array $raw = [];

    public function __construct(array $raw = [])
    {
        if (!empty($raw)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
    }

    public function add(Order $order): void
    {
        $this->objects[$this->total] = $order;
        $this->total++;
    }

    private function getRow(int $num): ?Order
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->createContentObject($this->raw[$num]);
            return $this->objects[$num];
        }

        return null;
    }

    private function createContentObject(array $raw): Order
    {
        return new Order(
            $raw['id'],
            $raw['product_name'],
            $raw['quantity'],
            $raw['total'],
        );
    }

    public function current(): ?Order
    {
        return $this->getRow($this->pointer);
    }

    public function next(): ?Order
    {
        $this->pointer++;
        return $this->current();
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function valid(): bool
    {
        return (!is_null($this->current()));
    }

    public function rewind()
    {
        $this->pointer = 0;
    }
}
