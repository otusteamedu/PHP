<?php

namespace Src\Routes;

use Klein\Klein;
use Klein\Request;
use Src\Controllers\EventController;

/**
 * Class Route
 *
 * @package App\Routes
 */
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

        $this->router->respond(
            'POST',
            '/add',
            static function (Request $request) {
                return (new EventController())->add($request);
            });

        $this->router->respond(
            'DELETE',
            '/delete-all',
            static function () {
                return (new EventController())->delete();
            });

        $this->router->respond(
            'GET',
            '/get-list',
            static function () {
                return (new EventController())->getList();
            });

        $this->router->respond(
            'GET',
            '/search',
            static function (Request $request) {
                return (new EventController())->search($request);
            });

        $this->router->dispatch();
    }
}
