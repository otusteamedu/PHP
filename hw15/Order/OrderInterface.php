<?php

declare(strict_types=1);

namespace App\Order;

interface OrderInterface
{
    public function getItems(): array;

    public function getTotalPrice();

    public function setTotalPrice($price);
}