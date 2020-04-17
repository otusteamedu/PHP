<?php

namespace App\Action;

use App\App;
use App\Domain\EventMapper;
use App\Responce;

class EventLoad
{
    public static function action(string $id): Responce
    {
        $mapper = new EventMapper(App::getRedis());
        $event = $mapper->load($id);
        return $event ? new Responce($event) : Responce::error(404);
    }
}
