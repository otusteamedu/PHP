<?php


namespace App;
use App\Order;
use App\FactoryMethodInterface;
use App\ApiInterface;


/**
 * Class OrderMapper
 * @package App
 */
class OrderMapper implements  FactoryMethodInterface ,ApiInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool|\PDOStatement
     */
    private  $insertStmt;
    /**
     * @var bool|\PDOStatement
     */
    private $selectStmt;
    /**
     * @var bool|\PDOStatement
     */
    private $updateStmt;
    /**
     * @var bool|\PDOStatement
     */
    private $selectStmtWhereName;
    /**
     * @var bool|\PDOStatement
     */
    private $deleteStmt;

    /**
     * OrderMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)

{
    $this->pdo=$pdo;

    $this->selectStmt = $pdo->prepare(
        "select id, name_order, full_price, coupon_id, client_id, delivery_service_id, type_id from public.order where id = ?"
    );
    $this->selectStmtWhereName = $pdo->prepare(
        "select id, name_order, full_price, coupon_id, client_id, delivery_service_id, type_id from public.order where name_order = ?"
    );
    $this->insertStmt = $pdo->prepare(
        "insert into public.order (name_order, full_price, coupon_id, client_id, delivery_service_id, type_id) values (?, ?, ?, ?, ?, ?)"
    );
    $this->updateStmt = $pdo->prepare(
        "update public.order  set id = ?, full_price = ?, coupon_id = ?, client_id = ?, delivery_service_id= ?, type_id = ? where name_order = ?"
    );
    $this->deleteStmt = $pdo->prepare("delete from public.order where name_order = ?");
}

    /**
     * @param $raw
     * @return Order
     */
    public function insert($raw)
    {

        $this->insertStmt->execute([
            $raw['name_order'],
            $raw['full_price'],
            $raw['coupon_id'],
            $raw['client_id'],
            $raw['delivery_service_id'],
            $raw['type_id']
        ]);

        return new Order(
         (int) $this->pdo->lastInsertId(),
            $raw['name_order'],
            $raw['full_price'],
            $raw['coupon_id'],
            $raw['client_id'],
            $raw['delivery_service_id'],
            $raw['type_id']);
    }
    /**
     * @param int $id
     *
     * @return  Order
     */
    public function findById(int $id):  Order
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new  Order(
            $id,
            $result['name_order'],
            $result['full_price'],
            $result['coupon_id'],
            $result['client_id'],
            $result['delivery_service_id'],
            $result['type_id']
        );
    }

    /**
     * @param $name
     * @return  Order
     */
    public function findByName( $name):  Order
    {
        $this->selectStmtWhereName->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmtWhereName->execute([$name]);
        $result = $this->selectStmtWhereName ->fetch();

        return new  Order(
            $result['id'],
            $result['name_order'],
            $result['full_price'],
            $result['coupon_id'],
            $result['client_id'],
            $result['delivery_service_id'],
            $result['type_id']
        );
    }

    /**
     * @param \App\Order $order
     * @return bool
     */
    public function update(Order $order): bool
    {
        return $this->updateStmt->execute([
            $order->getId(),
            $order->getFull_price(),
            $order->getCoupon_id(),
            $order->getClient_id(),
            $order->getDelivery_service_id(),
            $order->getType_id(),
            $order->getName(),
        ]);
    }
    /**
     * @param \AppOrder $order
     *
     * @return bool
     */
    public function delete(Order $order): bool
    {
        return $this->deleteStmt->execute([$order->getId()]);
    }



}