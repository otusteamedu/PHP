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
    public function getAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];
        $limit = $request->query->getInt('limit', 10);

        $pdoFactory = new PDOFactory();
        $orderMapper = new OrderMapper($pdoFactory->getPostgresPDO());

        if ($id === 0) {
            $orders = $orderMapper->findAll($limit);

            return new Response(json_encode($orders));
        } else {
            if (($order = $orderMapper->findById($id)) === null) {
                throw new \RuntimeException('Order not found', Response::HTTP_NOT_FOUND);
            }

            return new Response(json_encode($order));
        }
    }

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

    public function deleteAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];

        $pdoFactory = new PDOFactory();
        $orderMapper = new OrderMapper($pdoFactory->getPostgresPDO());

        if (($order = $orderMapper->findById($id)) === null) {
            throw new \RuntimeException('Order not found', Response::HTTP_NOT_FOUND);
        }
        $orderMapper->delete($order);

        return new Response(json_encode($order));
    }

    public function patchAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];

        $pdoFactory = new PDOFactory();
        $postgresPDO = $pdoFactory->getPostgresPDO();
        $orderMapper = new OrderMapper($postgresPDO);

        if (($order = $orderMapper->findById($id)) === null) {
            throw new \RuntimeException('Order not found', Response::HTTP_NOT_FOUND);
        }
        $orderArray = json_decode($request->getContent(), true);
        $order->handleArray($orderArray);
        if (isset($orderArray['customer_id'])) {
            $customerMapper = new CustomerMapper($postgresPDO);
            $order->setCustomer($customerMapper->findById($orderArray['customer_id']));
        }
        $orderMapper->update($order);

        return new Response(json_encode($order));
    }
}
