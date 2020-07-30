<?php

namespace App\Controllers;


use Classes\Repositories\ResponseHandler;
use Services\BrokerServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class SubscriberController
{
    private $brokerService;

    public function __construct(BrokerServiceInterface $brokerService)
    {
        $this->brokerService = $brokerService;
    }

    public function run(Request $request, Response $response, $args)
    {
        $this->brokerService->handleRequest();
        return ResponseHandler::getResponse($response, 'обработано', 1);
    }
}
