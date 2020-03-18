<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\OrderProductShipment;

class OrderProductShipmentMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO order_product_shipments (order_product_id, shipment_id) 
            VALUES (:order_product_id, :shipment_id)
        ');
    }

    public function insert(OrderProductShipment $orderProductShipment): OrderProductShipment
    {
        $this->insertStatement->execute([
            'order_product_id' => $orderProductShipment->getOrderProduct()->getId(),
            'shipment_id' => $orderProductShipment->getShipment()->getId(),
        ]);

        return $orderProductShipment;
    }
}
