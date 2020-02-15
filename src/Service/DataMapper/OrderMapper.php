<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Order;

class OrderMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    private \PDOStatement $updateStatement;

    private \PDOStatement $deleteStatement;

    private \PDOStatement $selectStatement;

    private \PDOStatement $selectAllStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectAllStatement = $this->pdo->prepare('SELECT * FROM orders LIMIT :limit');
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM orders WHERE id = :id');
        $this->insertStatement = $this->pdo->prepare('INSERT INTO orders (created_at, sum, customer_id) VALUES (:created_at, :sum, :customer_id)');
        $this->updateStatement = $this->pdo->prepare('UPDATE orders SET created_at = :created_at, sum = :sum, customer_id = :customer_id WHERE id = :id');
        $this->deleteStatement = $this->pdo->prepare('DELETE FROM orders WHERE id = :id');
    }

    /**
     * @param int $limit
     * @return array|Order[]
     */
    public function findAll(int $limit = 10): array
    {
        $this->selectAllStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute([
            'limit' => $limit
        ]);

        $customerMapper = new CustomerMapper($this->pdo);
        $orders = [];
        foreach ($this->selectAllStatement->fetchAll() as $result) {
            $order = new Order();
            $order->setId($result['id']);
            $order->setCreatedAt(new \DateTime($result['created_at']));
            $order->setSum((float)$result['sum']);
            $customerId = $result['customer_id'];
            $customerReference = function () use ($customerMapper, $customerId) {
                return $customerMapper->findById($customerId);
            };
            $order->setCustomerReference($customerReference);

            $orders[] = $order;
        }

        return $orders;
    }

    public function findById(int $id): ?Order
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);
        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $order = new Order();
        $order->setId($result['id']);
        $order->setCreatedAt(new \DateTime($result['created_at']));
        $order->setSum((float)$result['sum']);

        $customerMapper = new CustomerMapper($this->pdo);
        $customerId = $result['customer_id'];
        $customerReference = function () use ($customerMapper, $customerId) {
            return $customerMapper->findById($customerId);
        };
        $order->setCustomerReference($customerReference);

        return $order;
    }

    public function insert(Order $order): Order
    {
        $this->insertStatement->execute([
            'created_at' => $order->getCreatedAt()->format(DATE_ISO8601),
            'sum' => $order->getSum(),
            'customer_id' => $order->getCustomer()->getId(),
        ]);
        $order->setId((int)$this->pdo->lastInsertId());

        return $order;
    }

    public function update(Order $order): bool
    {
        return $this->updateStatement->execute([
            'id' => $order->getId(),
            'created_at' => $order->getCreatedAt()->format(DATE_ISO8601),
            'sum' => $order->getSum(),
            'customer_id' => $order->getCustomer()->getId(),
        ]);
    }

    public function delete(Order $order): bool
    {
        return $this->deleteStatement->execute([
            'id' => $order->getId()
        ]);
    }
}
