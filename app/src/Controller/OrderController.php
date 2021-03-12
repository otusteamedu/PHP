<?php

namespace Otus\Controller;

use Otus\Payment\PaymentService;
use Otus\Repository\OrderRepository;
use Otus\Request\AppRequest;
use Otus\Response\AppResponse;
use Otus\Validator\OrderValidator;

class OrderController
{
    public function makeOrder()
    {
        $requestData = new AppRequest();

        $validator = new OrderValidator($requestData->getData());
        $validator->validate();

        $paymentService = new PaymentService($requestData->getData());
        $result = $paymentService->pay();

        $orderRepository = new OrderRepository($result);
        $orderRepository->save();

        AppResponse::response(['order_status' => 'completed']);
    }
}