<?php


namespace App;
use App\Order;
use App\FactoryMethodInterface;
class OrderMapper implements  FactoryMethodInterface
{
private $pdo;

private  $insertStmt;
private $selectStmt;

public function __construct(\PDO $pdo)

{
    $this->pdo=$pdo;

    $this->selectStmt = $pdo->prepare(
        "select id, name_order, full_price, coupon_id, client_id, delivery_service_id, type_id from public.order where id = ?"
    );
    $this->insertStmt = $pdo->prepare(
        "insert into public.order (name_order, full_price, coupon_id, client_id, delivery_service_id, type_id) values (?, ?, ?, ?, ?, ?)"
    );
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
            $raw['client_id,'],
            $raw['delivery_service_id'],
            $raw['type_id']
        ]);

        return new Order(
            (int) $this->pdo->lastInsertId(),
            $raw['name_order'],
            $raw['full_price'],
            $raw['coupon_id'],
            $raw['client_id,'],
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
            $result['client_id,'],
            $result['delivery_service_id'],
            $result['type_id']
        );
    }



}