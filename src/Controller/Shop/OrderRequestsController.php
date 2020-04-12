<?php declare(strict_types=1);

namespace Controller\Shop;

use Service\Database\PDOFactory;
use Service\DataMapper\OrderRequestMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderRequestsController
{
    public function getAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[4];

        $pdoFactory = new PDOFactory();
        $orderRequestMapper = new OrderRequestMapper($pdoFactory->getPostgresPDO());

        if (($orderRequest = $orderRequestMapper->fetchArrayById($id)) === null) {
            throw new \RuntimeException('Request not found', Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode([
            'status' => $orderRequest['order_id'] !== null,
            'order_id' => $orderRequest['order_id']
        ]));
    }
}
