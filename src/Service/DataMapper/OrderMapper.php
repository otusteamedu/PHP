<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Order;

class OrderMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO orders (created_at, sum, status, type, customer_id, discount_id) 
            VALUES (:created_at, :sum, :status, :type, :customer_id, :discount_id)
        ');
    }

    public function insert(Order $order): Order
    {
        $this->insertStatement->execute([
            'created_at' => $order->getCreatedAt()->format(DATE_ISO8601),
            'sum' => $order->getSum(),
            'status' => $order->getStatus(),
            'type' => $order->getType(),
            'customer_id' => $order->getCustomer()->getId(),
            'discount_id' => $order->getDiscount()->getId(),
        ]);
        $order->setId((int)$this->pdo->lastInsertId());

        return $order;
    }
}
