<?php

namespace App\Controllers;

use App\Services\RedisEventService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventsController
{
    private RedisEventService $eventService;

    /**
     * EventsController constructor.
     * @param RedisEventService $eventService
     */
    public function __construct(RedisEventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $response = $this->eventService->getAllEvents();

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addEvent(Request $request): JsonResponse
    {
        $response = $this->eventService->addEvent($request->toArray());

        return new JsonResponse($response->toArray());
    }

    /**
     * @return JsonResponse
     */
    public function flushAllEvents(): JsonResponse
    {
        $response = $this->eventService->flushAllEvents();

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchForEvents(Request $request): JsonResponse
    {
        $response = $this->eventService->searchEventsByParams($request->toArray());

        return new JsonResponse($response->toArray());
    }
}
