<?php declare(strict_types=1);

namespace Controller\Shop;

use Service\OrderFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    public function postAction(Request $request): Response
    {
        $orderFactory = new OrderFactory();
        $order = $orderFactory->createOrder($request);

        return new Response(sprintf('%f', $order->getSum()));
    }
}
