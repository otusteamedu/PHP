<?php

namespace Src\Routes;

use Klein\Klein;
use Klein\Request;
use Src\Controllers\PatternController;

/**
 * Class Route
 *
 * @package Src\Routes
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
            'GET',
            '/get-list-data-mapper',
            static function (Request $request) {
                return (new PatternController())->getRecordsDataMapper($request);
            });

        $this->router->respond(
            'GET',
            '/get-list-active-record',
            static function (Request $request) {
                return (new PatternController())->getRecordsActiveRecord($request);
            });

        $this->router->dispatch();
    }
}