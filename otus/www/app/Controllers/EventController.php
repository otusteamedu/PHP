<?php

namespace App\Controllers;

use Classes\Dto\EventDtoBuilder;
use Classes\ResponseHandler;
use Services\EventServiceImpl;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class EventController
{
    private $eventServiceImpl;

    public function __construct(EventServiceImpl $eventServiceImpl)
    {
        $this->eventServiceImpl = $eventServiceImpl;
    }

    public function getPriority(Request $request, Response $response, $args)
    {

        $requestData = $request->getParsedBody();
        $eventDtoBuilder = new EventDtoBuilder();

        try {
            $eventDto = $eventDtoBuilder
                ->setEventName($requestData['eventName'] ?? null)
                ->setEventPriority($requestData['eventPriority'] ?? null)
                ->setEventCriterions($requestData['eventCriterions'])
                ->build()
            ;
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        $events = null;

        try {
           $events = $this->eventServiceImpl->getPriority($eventDto);
        } catch (\Exception $exception) {

            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
            return $response;
        }

        $result = [
            'success' => true,
            'events' => json_encode($events, JSON_THROW_ON_ERROR, 512)
        ];

        $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
        return $response;
    }
}
