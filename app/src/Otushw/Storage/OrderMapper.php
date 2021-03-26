<?php


namespace Otushw\Storage;

use Otushw\DTOs\OrderDTO;
use PDO;
use PDOStatement;
use PDOException;
use Otushw\Models\Order;
use Otushw\Exception\AppException;

class OrderMapper implements MapperInterface
{

    private PDO $pdo;
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $batchStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select id, product_name, quantity, total from orders where id = ?"
        );

        $this->insertStmt = $pdo->prepare(
            "insert into orders (product_name, quantity, total) values (?, ?, ?)"
        );

        $this->updateStmt = $pdo->prepare(
            "update orders set id = ?, product_name = ?, quantity = ?, total = ? where id = ?"
        );

        $this->deleteStmt = $pdo->prepare("delete from orders where id = ?");

        $this->batchStmt = $pdo->prepare(
            'select  id, product_name, quantity, total from orders order by id DESC limit ?  offset ?'
        );
    }

    public function findById(int $id): ?Order
    {
        try {
            $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectStmt->execute([$id]);
            $result = $this->selectStmt->fetch();
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            return null;
        }

        $order = new Order(
            $id,
            $result['product_name'],
            $result['quantity'],
            $result['total'],
        );

        return $order;
    }

    public function insert(OrderDTO $order): Order
    {
        try {
            $result = $this->insertStmt->execute([
                $order->productName,
                $order->quantity,
                $order->total
            ]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            throw new AppException('It is not possible to add a record'
                .  ' (' . $order . ') to table "order"');
        }

        $id = (int) $this->pdo->lastInsertId('orders_id_seq');
        $order = new Order(
            (int) $id,
            $order->productName,
            $order->quantity,
            $order->total
        );
        return $order;
    }

    public function update(Order $order): bool
    {
        $id = $order->getId();
        try {
            $result = $this->updateStmt->execute([
                $id,
                $order->getProductName(),
                $order->getQuantity(),
                $order->getTotal(),
                $id
            ]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

    public function delete(int $orderID): bool
    {
        try {
            $result = $this->deleteStmt->execute([$orderID]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

    public function getBatch(int $limit = 5, int $offset = 0): ?OrderCollection
    {
        try{
            $this->batchStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->batchStmt->execute([$limit, $offset]);
            $result = $this->batchStmt->fetchAll();
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            return null;
        }
        return new OrderCollection($result);
    }
}