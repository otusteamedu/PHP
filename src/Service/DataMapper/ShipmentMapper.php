<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\AbstractOrder;
use Entity\Shop\Shipment;

class ShipmentMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    private \PDOStatement $setFreeShippingStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO shipments (shipping_system_id, date, sum, order_id) 
            VALUES (:shipping_system_id, :date, :sum, :order_id)
        ');
        $this->setFreeShippingStatement = $this->pdo->prepare('
            UPDATE shipments SET sum = 0 WHERE order_id = :order_id
        ');
    }

    public function insert(Shipment $shipment): Shipment
    {
        $this->insertStatement->execute([
            'shipping_system_id' => $shipment->getShippingSystem()->getId(),
            'date' => $shipment->getDate()->format(DATE_ISO8601),
            'sum' => $shipment->getSum(),
            'order_id' => $shipment->getOrder()->getId(),
        ]);
        $shipment->setId((int)$this->pdo->lastInsertId());

        return $shipment;
    }

    public function setFreeShipping(AbstractOrder $order): void
    {
        $this->setFreeShippingStatement->execute([
            'order_id' => $order->getId()
        ]);

        return;
    }
}
