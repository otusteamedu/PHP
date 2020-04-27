<?php


namespace Controller;


use Service\EventStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController
{

    private EventStorage $channelStorage;

    public function __construct()
    {
        $this->channelStorage = new EventStorage();
    }

    public function add(Request $request): Response
    {
        $event = json_decode($request->getContent(), true);
        $key = $this->resolveKey($event['conditions'][0]);

        return new Response(json_encode($this->channelStorage->add($key, [json_encode($event) => $event['priority']])));
    }

    public function clear(): Response
    {
        return new Response(json_encode($this->channelStorage->clear()));
    }

    public function find(Request $request): Response
    {
        $eventConditions = json_decode($request->getContent(), true);
        $key = $this->resolveKey($eventConditions['params'][0]);
        $event = $this->channelStorage->find($key);
        return new Response($event);
    }

    private function resolveKey(array $params): string
    {
        $key = [];
        foreach ($params as $paramName => $paramValue) {
            $key[] = $paramName . '=' . $paramValue;
        }
        asort($key);

        return 'event:' . join('+', $key);
    }


}