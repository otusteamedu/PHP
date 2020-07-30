<?php

namespace Services;

use Classes\Dto\OrderDto;

interface OrderServiceInterface
{
    public function createOrder(OrderDto $orderDto): int;

    public function deleteOrder(int $orderId): bool;
}
