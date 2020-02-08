<?php declare(strict_types=1);

namespace Controller;

use HttpException;
use Repository\EventsRepository;
use Service\RedisKeyResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsController
{
    public function getAction(Request $request): Response
    {
        $keyResolver = new RedisKeyResolver();
        $eventsRepository = new EventsRepository();

        $eventConditions = $request->query->all();
        $key = $keyResolver->resolveKey($eventConditions['params']);

        $event = $eventsRepository->findOne($key);

        return new Response($event);
    }

    public function postAction(Request $request): Response
    {
        $keyResolver = new RedisKeyResolver();
        $eventsRepository = new EventsRepository();

        $event = json_decode($request->getContent(), true);
        $key = $keyResolver->resolveKey($event['conditions']);

        $result = $eventsRepository->save($key, [json_encode($event) => $event['priority']]);

        return new Response(json_encode($result));
    }

    public function deleteAction(Request $request): Response
    {
        $keyResolver = new RedisKeyResolver();
        $eventsRepository = new EventsRepository();

        $eventConditions = $request->query->all();
        $key = $keyResolver->resolveKey($eventConditions['params']);

        $event = $eventsRepository->findOne($key);
        if ($event === null) {
            throw new \Exception('Event not found', Response::HTTP_NOT_FOUND);
        }
        $eventsRepository->delete($key, $event);

        return new Response($event);
    }
}
