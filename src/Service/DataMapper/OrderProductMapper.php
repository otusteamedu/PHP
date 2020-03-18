<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\OrderProduct;

class OrderProductMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO order_products (order_id, product_id, sum) 
            VALUES (:order_id, :product_id, :sum)
        ');
    }

    public function insert(OrderProduct $orderProduct): OrderProduct
    {
        $this->insertStatement->execute([
            'order_id' => $orderProduct->getOrder()->getId(),
            'product_id' => $orderProduct->getProduct()->getId(),
            'sum' => $orderProduct->getSum(),
        ]);
        $orderProduct->setId((int)$this->pdo->lastInsertId());

        return $orderProduct;
    }
}
