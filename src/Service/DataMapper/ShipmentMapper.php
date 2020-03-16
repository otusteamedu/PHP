<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Shipment;

class ShipmentMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    private \PDOStatement $updateStatement;

    private \PDOStatement $selectByOrderStatement;

    private ShippingSystemMapper $shippingSystemMapper;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        //$this->shippingSystemMapper = new ShippingSystemMapper($pdo);
        $this->insertStatement = $this->pdo->prepare('
            INSERT INTO shipments (shipping_system_id, date, sum, order_id) 
            VALUES (:shipping_system_id, :date, :sum, :order_id)
        ');
        $this->insertStatement = $this->pdo->prepare('
            UPDATE shipments SET shipping_system_id = :shipping_system_id, date = :date, sum = :sum, order_id = :order_id
            WHERE id = :id
        ');
        $this->selectByOrderStatement = $this->pdo->prepare('SELECT * FROM shipments WHERE order_id = :order_id');
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

    public function findByOrderId(int $orderId): array
    {
        $this->selectByOrderStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByOrderStatement->execute([
            'order_id' => $orderId
        ]);

        $shipments = [];
        while (($result = $this->selectByOrderStatement->fetch()) !== false) {
            $shipment = new Shipment();
            $shipment->setId((int)$result['id']);
            $shipment->setShippingSystem($this->shippingSystemMapper->findById((int)$result['shipping_system_id']));
            $shipment->setSum((float)$result['sum']);
            $shipment->setDate(new \DateTime($result['date']));

            $shipments[] = $shipment;
        }

        return $shipments;
    }

    public function update(Shipment $shipment): bool
    {
        return $this->updateStatement->execute([
            'id' => $shipment->getId(),
            'shipping_system_id' => $shipment->getShippingSystem()->getId(),
            'order_id' => $shipment->getOrder()->getId(),
            'date' => $shipment->getDate()->format(DATE_ISO8601),
            'sum' => $shipment->getSum(),
        ]);
    }
}
