<?php declare(strict_types=1);

namespace Service\OrderObservers;

use Entity\Shop\AbstractOrder;
use Service\Database\PDOFactory;
use Service\DataMapper\ShipmentMapper;
use SplSubject;

class FreeShippingOrderObserver implements \SplObserver
{
    public const FREE_SHIPPING_THRESHOLD = 1000;

    private ShipmentMapper $shipmentMapper;

    public function __construct()
    {
        $pdoFactory = new PDOFactory();
        $postgresPDO = $pdoFactory->getPostgresPDO();
        $this->shipmentMapper = new ShipmentMapper($postgresPDO);
    }

    public function update(SplSubject $subject)
    {
        /** @var AbstractOrder $subject */
        if ($subject->getSum() >= self::FREE_SHIPPING_THRESHOLD) {
            $this->shipmentMapper->setFreeShipping($subject);
        }
    }
}
