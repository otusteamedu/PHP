<?php

namespace App\EntityInterface;

use PDO;

interface IClient
{
    /**
     * @param PDO $pdo
     * @return IOrder
     */
    public function createOrder(PDO $pdo): IOrder;
}