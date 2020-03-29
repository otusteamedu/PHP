<?php declare(strict_types=1);

namespace Controller\Shop;

use Entity\Shop\OrderRequest;
use Service\Amqp\Producer\OrderCreateProducer;
use Service\Database\PDOFactory;
use Service\DataMapper\OrderRequestMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    public function postAction(Request $request): Response
    {
        $pdoFactory = new PDOFactory();
        $orderRequestMapper = new OrderRequestMapper($pdoFactory->getPostgresPDO());
        $orderCreateProducer = new OrderCreateProducer();

        $orderRequest = new OrderRequest();
        $orderRequest->setOrderPayload($request->getContent());
        $orderRequestMapper->insert($orderRequest);

        $orderCreateProducer->publish(json_encode([
            'request_id' => $orderRequest->getId(),
            'payload' => $orderRequest->getOrderPayload(),
        ]));

        return new Response(json_encode([
            'request_id' => $orderRequest->getId(),
        ]));
    }
}
