<?php

namespace App\Controllers;

use Classes\Dto\EventDtoBuilder;
use Services\EventServiceImpl;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class EventCrudController
{
    private $eventServiceImpl;

    public function __construct(EventServiceImpl $eventServiceImpl)
    {
       $this->eventServiceImpl = $eventServiceImpl;
    }

    public function create(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();
        $eventDtoBuilder = new EventDtoBuilder();

        try {
            $eventDto = $eventDtoBuilder
                ->setEventName($requestData['eventName'])
                ->setEventPriority($requestData['eventPriority'])
                ->setEventCriterions($requestData['eventCriterions'])
                ->build()
            ;
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        try {
            $this->eventServiceImpl->create($eventDto);
        } catch (\Exception $exception) {

            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR, 512));
            return $response;
        }

        $result = [
            'success' => true,
            'message' => 'Событие успешно добавлено'
        ];

        $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR, 512));
        return $response;
    }

    public function delete(Request $request, Response $response, $args)
    {
        try {
            $this->eventServiceImpl->deleteAll();
        } catch(\Exception $exception) {
            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR, 512));
            return $response;
        }
        $result = [
            'success' => true,
            'message' => 'Событие успешно удалено'
        ];

        $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR, 512));
        return $response;
    }
}
