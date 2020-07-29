<?php

namespace Services;

use Classes\Dto\OrderDto;

interface OrderServiceInterface
{
    public function createOrder(OrderDto $orderDto);

    public function deleteOrder(int $orderId);
}
