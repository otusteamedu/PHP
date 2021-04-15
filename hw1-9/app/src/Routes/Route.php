<?php

namespace Src\Routes;

use Klein\Klein;
use Src\Controllers\YoutubeController;

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

        $this->router->respond('GET', '/grub', static fn() => (new YoutubeController())->grub());

        $this->router->dispatch();
    }
}