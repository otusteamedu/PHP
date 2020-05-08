<?php

namespace App\Routes;

use App\Controllers\EventController;
use Klein\Klein;

class Route
{
    /**
     * @var Klein
     */
    private Klein $router;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new Klein();
    }

    public function init(): void
    {
        $this->router->respond('GET', '/events', static function ($request) {
            return (new EventController)->get($request);
        });
        $this->router->respond('POST', '/events', static function ($request) {
            return (new EventController)->post($request);
        });
        $this->router->respond('DELETE', '/events', static function () {
            return (new EventController)->deleteAll();
        });

        $this->router->dispatch();
    }
}