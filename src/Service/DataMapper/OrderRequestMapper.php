<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\OrderRequest;

class OrderRequestMapper
{
    private \PDO $pdo;
    private \PDOStatement $selectStatement;
    private \PDOStatement $insertStatement;
    private \PDOStatement $updateOrderIdStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM order_requests WHERE id = :id');
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO order_requests (order_id, order_payload) 
            VALUES (:order_id, :order_payload)
        ');
        $this->updateOrderIdStatement = $this->pdo->prepare('
            UPDATE order_requests 
            SET order_id = :order_id
            WHERE id = :id
        ');
    }

    public function fetchArrayById(int $id): ?array
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);
        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        return $result;
    }

    public function insert(OrderRequest $orderRequest): OrderRequest
    {
        if (($order = $orderRequest->getOrder()) === null) {
            $orderId = null;
        } else {
            $orderId = $order->getId();
        }

        $this->insertStatement->execute([
            'order_id' => $orderId,
            'order_payload' => $orderRequest->getOrderPayload(),
        ]);
        $orderRequest->setId((int)$this->pdo->lastInsertId());

        return $orderRequest;
    }

    public function updateOrderId(int $id, int $orderId): bool
    {
        return $this->updateOrderIdStatement->execute([
            'id' => $id,
            'order_id' => $orderId,
        ]);
    }
}
