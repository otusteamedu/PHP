<?php

namespace App\Controllers;

use Classes\Dto\PushDtoBuilder;
use Classes\Repositories\ResponseHandler;
use Services\BrokerServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PublisherController
{
    private $brokerService;

    public function __construct(BrokerServiceInterface $brokerService)
    {
        $this->brokerService = $brokerService;
    }
    public function push(Request $request, Response $response, $args)
    {

        $requestData = $request->getParsedBody();

        $pushDtoBuilder = new PushDtoBuilder();

        try {
            $pushDto = $pushDtoBuilder
                ->setId($requestData['id'])
                ->setMessage($requestData['message'])
                ->build();
        } catch (\Exception $exception) {
            return ResponseHandler::getResponse($response, $exception->getMessage(), 0);
        }

        $requestId = $this->brokerService->pushRequest($pushDto);

        return ResponseHandler::getResponse(
            $response, sprintf('Отправка прошла успешно. Id запроса %s', $requestId), 1);
    }

    public function getStatus(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();
        if (!$requestData['id']) {
            return ResponseHandler::getResponse($response, 'Не передан id запроса', 0);
        }

        $requestStatus = $this->brokerService->getRequestStatusById($requestData['id']);
        if (!$requestStatus) {
            return ResponseHandler::getResponse($response, 'Не получен статус', 0);
        }

        return ResponseHandler::getResponse($response, sprintf('статус %s', $requestStatus), 1);
    }
}
