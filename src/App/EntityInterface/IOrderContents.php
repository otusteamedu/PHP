<?php

namespace App\EntityInterface;

use App\Entity\Order;
use PDO;

interface IOrderContents
{
    /**
     * @param Order $order
     * @return $this
     */
    public function update(Order $order): self;
}