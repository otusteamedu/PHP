<?php

namespace Otus\Http;

use JsonException;
use Otus\Event;
use Otus\Exceptions\InvalidEventDataException;

class EventController
{
    private Event $event;

    public function __construct()
    {
        $this->event = new Event();
    }

    public function store(Request $request): ResponseContract
    {
        try {
            $this->event->save($request->get());
        } catch (InvalidEventDataException|JsonException $exception) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }

        return new JsonResponse(Response::HTTP_CREATED, $this->event);
    }

    public function show(Request $request): ResponseContract
    {
        if (! $request->has('conditions')) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, 'Error');
        }

        try {
            $this->event->get($request->get('conditions'));
        } catch (JsonException $exception) {
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(Response::HTTP_OK, $this->event);
    }

    public function delete(): ResponseContract
    {
        if (! $this->event->flush()) {
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(Response::HTTP_OK, 'OK');
    }
}
