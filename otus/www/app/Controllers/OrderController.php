<?php

namespace App\Controllers;

use Classes\Dto\OrderDtoBuilder;
use Classes\Models\OrderStatus;
use Classes\ResponseHandler;
use Services\OrderServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class OrderController
{
    private $orderService;

    public function __construct
    (
        OrderServiceInterface $orderService
    )
    {
        $this->orderService = $orderService;
    }

    public function createOrder(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();

        $orderDtoBuilder = new OrderDtoBuilder();

        try {
            $orderDto = $orderDtoBuilder
                ->setType($requestData['type'])
                ->setDiscountType($requestData['discountType'])
                ->setDelivery($requestData['delivery'])
                ->setProducts($requestData['products'])
                ->setCost($requestData['cost'])
                ->setStatus(OrderStatus::NEW_ORDER)
                ->setUserId($requestData['userId'])
                ->build()
            ;
        } catch (\Exception $exception) {
            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
            return $response;
        }

        $orderId = $this->orderService->createOrder($orderDto);

        if (!$orderId) {
            $result = [
                'success' => false,
                'message' => 'Не удалось создать заказ, обратитесь к менеджеру'
            ];

            $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
            return $response;
        }

        $result = [
            'success' => true,
            'message' => 'Заказ успешно создан'
        ];

        $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
        return $response;
    }
}
