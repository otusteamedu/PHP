<?php

declare(strict_types=1);

namespace App\Order;

use Exception;

class OrderFactory
{
    /**
     * @param array $data
     * @return OrderInterface
     * @throws Exception
     */
    public static function getOrder(array $data): OrderInterface
    {
        switch ($data['type']) {
            case "b2c":
                return new IndividualOrder($data);
            case "b2b":
                return new CompanyOrder($data);
            default:
                throw new Exception("Неподдерживаемый тип заказа");
        }
    }
}