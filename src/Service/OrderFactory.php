<?php declare(strict_types=1);

namespace Service;

use Entity\Shop\AbstractOrder;
use Entity\Shop\B2bOrder;
use Entity\Shop\B2cOrder;
use Service\Exception\OrderFactoryException;

class OrderFactory
{
    public function createOrder(string $orderType): AbstractOrder
    {
        switch ($orderType) {
            case AbstractOrder::ORDER_TYPE_B2B:
                return new B2bOrder();
            case AbstractOrder::ORDER_TYPE_B2C:
                return new B2cOrder();
            default:
                throw new OrderFactoryException('Incorrect order type');
        }
    }
}
