<?php

declare(strict_types=1);

namespace Entity\Shop;

class OrderRequest
{
    private int $id;

    private ?AbstractOrder $order = null;

    private string $orderPayload;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOrder(): ?AbstractOrder
    {
        return $this->order;
    }

    public function setOrder(?AbstractOrder $order): void
    {
        $this->order = $order;
    }

    public function getOrderPayload(): string
    {
        return $this->orderPayload;
    }

    public function setOrderPayload(string $orderPayload): void
    {
        $this->orderPayload = $orderPayload;
    }
}
