<?php declare(strict_types=1);

namespace Service;

use Entity\Shop\AbstractOrder;
use Entity\Shop\B2bOrder;
use Entity\Shop\B2cOrder;
use Service\Exception\OrderFactoryException;
use Service\OrderNotifier\EmailNotifier;
use Service\OrderNotifier\SmsNotifier;

class OrderFactory
{
    public function createOrder(string $orderType): AbstractOrder
    {
        switch ($orderType) {
            case AbstractOrder::ORDER_TYPE_B2B:
                $order = new B2bOrder();
                $order->setNotifier(new EmailNotifier());
                break;
            case AbstractOrder::ORDER_TYPE_B2C:
                $order = new B2cOrder();
                $order->setNotifier(new SmsNotifier());
                break;
            default:
                throw new OrderFactoryException('Incorrect order type');
        }

        return $order;
    }
}
