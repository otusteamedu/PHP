<?php

namespace App\Controllers;

use App\DB\RedisDB;
use App\Messages\MessageWeb;
use App\Repositories\EventRepository;
use JsonException;
use Klein\Request;

class EventController
{

    /**
     * @param Request $request
     * @return null
     */
    public function get(Request $request)
    {
        $eventsRepository = new EventRepository(new RedisDB());

        try {
            $event = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
        $params = $event['params'];

        $event = $eventsRepository->find($params);

        try {
            return MessageWeb::sendOk(json_encode($event, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

    }

    /**
     * @param Request $request
     * @return null
     */
    public function post(Request $request)
    {
        try {
            $event = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        $eventsRepository = new EventRepository(new RedisDB());

        $key ='events:'. md5(uniqid('', true));

        try {
            $result = $eventsRepository->save($key, [json_encode($event, JSON_THROW_ON_ERROR)]);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        try {
            if(!$result) {
                return MessageWeb::sendOk(json_encode(['message' => 'Event it already exists'], JSON_THROW_ON_ERROR));
            }
            return MessageWeb::sendOk(json_encode(['message' => 'Event add'], JSON_THROW_ON_ERROR));

        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    /**
     * @return null
     */
    public function deleteAll()
    {
        $eventsRepository = new EventRepository(new RedisDB());

        $eventsRepository->deleteAll();

        try {
            return MessageWeb::sendOk(json_encode([
                'message' => 'Events remove'
            ], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }
}