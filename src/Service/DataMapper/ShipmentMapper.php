<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Shipment;

class ShipmentMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO shipments (shipping_system_id, order_product_id, date, sum) 
            VALUES (:shipping_system_id, :order_product_id, :date, :sum)
        ');
    }

    public function insert(Shipment $shipment): Shipment
    {
        $this->insertStatement->execute([
            'shipping_system_id' => $shipment->getShippingSystem()->getId(),
            'order_product_id' => $shipment->getOrderProduct()->getId(),
            'date' => $shipment->getDate()->format(DATE_ISO8601),
            'sum' => $shipment->getSum(),
        ]);
        $shipment->setId((int)$this->pdo->lastInsertId());

        return $shipment;
    }
}
