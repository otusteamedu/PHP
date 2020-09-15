<?php


namespace Models\Orders;

use Controllers\Contracts\OrdersInterface;
use Controllers\DataBaseControllers\PostgresConnection;
use PDO;


class OrdersMapper implements OrdersInterface {

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $insertStmt;

    /**
     * @var PDOStatement
     */
    private $updateStmt;

    /**
     * @var PDOStatement
     */
    private $deleteStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare(
            "INSERT INTO orders (amount, is_payed) values (?, ?)"
        );

        $this->updateStmt = $pdo->prepare(
            "UPDATE orders SET amount = ?, is_payed = ? WHERE id = ?"
        );

        $this->deleteStmt = $pdo->prepare(
            "DELETE FROM orders WHERE id = ?"
        );
    }



    /**
     * Обновление в БД заказа при успешной оплате
     * @param string $orderNumber
     * @param float $sum
     * @return bool
     */
    public function setOrderIsPaid(Order $order): bool
    {
        return $this->updateStmt->execute([
            $order->getId(),
            $order->getSum(),
            $order->getIsPayed()
        ]);
    }

    /**
     * Добавление заказа
     * @param Order $order
     * @return Order
     */
    public function setOrder(Order $order): Order
    {
        $this->insertStmt->execute([
            $order->getSum(),
            $order->getIsPayed()
        ]);

        return new Order(
            (int) $this->pdo->lastInsertId(),
            $order->getSum(),
            $order->getIsPayed()
        );
    }

    /**
     * Удаление заказа
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}