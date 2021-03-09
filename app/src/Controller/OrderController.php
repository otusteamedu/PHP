<?php

namespace Otus\Controller;

use Otus\Exceptions\ValidationException;
use Otus\Payment\PaymentService;
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
        $paymentService->pay();

        AppResponse::response(['order_status' => 'completed']);
    }
}