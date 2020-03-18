<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\AbstractOrder;

class OrderMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    private \PDOStatement $updateStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO orders (created_at, status, type, customer_id, discount_id) 
            VALUES (:created_at, :status, :type, :customer_id, :discount_id)
        ');
        $this->updateStatement = $this->pdo->prepare('
            UPDATE orders 
            SET customer_id = :customer_id, discount_id = :discount_id, created_at = :created_at, status = :status, type = :type 
            WHERE id = :id
        ');
    }

    public function insert(AbstractOrder $order): AbstractOrder
    {
        $discountId = $order->getDiscount() !== null ? $order->getDiscount()->getId() : null;
        $this->insertStatement->execute([
            'created_at' => $order->getCreatedAt()->format(DATE_ISO8601),
            'status' => $order->getStatus(),
            'type' => $order->getType(),
            'customer_id' => $order->getCustomer()->getId(),
            'discount_id' => $discountId,
        ]);
        $order->setId((int)$this->pdo->lastInsertId());

        return $order;
    }

    public function update(AbstractOrder $order): bool
    {
        $discountId = $order->getDiscount() !== null ? $order->getDiscount()->getId() : null;

        return $this->updateStatement->execute([
            'id' => $order->getId(),
            'created_at' => $order->getCreatedAt()->format(DATE_ISO8601),
            'status' => $order->getStatus(),
            'type' => $order->getType(),
            'customer_id' => $order->getCustomer()->getId(),
            'discount_id' => $discountId,
        ]);
    }
}
