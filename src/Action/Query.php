<?php

namespace App\Action;

use App\Domain\EventMapper;
use App\App;
use App\Responce;
use JsonException;

class Query
{
    public static function action(): Responce
    {
        $query = null;
        try {
            $query = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }

        if (!is_array($query) || !isset($query['params']) || !is_array($query['params'])) {
            return Responce::error(400);
        }

        $mapper = new EventMapper(App::getRedis());
        $event = $mapper->find($query['params']);

        return $event ? new Responce($event->event) : Responce::error(404);
    }
}
