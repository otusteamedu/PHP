<?php declare(strict_types=1);

namespace Controller\Shop;

use Entity\Shop\Order;
use Service\Database\PDOFactory;
use Service\DataMapper\CustomerMapper;
use Service\DataMapper\OrderMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    public function postAction(Request $request): Response
    {
        $order = new Order();
        $orderArray = json_decode($request->getContent(), true);
        $order->handleArray($orderArray);

        $pdoFactory = new PDOFactory();
        $postgresPDO = $pdoFactory->getPostgresPDO();
        $orderMapper = new OrderMapper($postgresPDO);
        $customerMapper = new CustomerMapper($postgresPDO);
        $order->setCustomer($customerMapper->findById($orderArray['customer_id']));
        $orderMapper->insert($order);

        return new Response(json_encode($order));
    }
}
