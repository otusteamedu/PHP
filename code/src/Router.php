<?php

namespace crazydope\theater;

use crazydope\theater\database\ResultSet;
use crazydope\theater\Job\Queue;
use Pecee\SimpleRouter\Event\EventArgument;
use Pecee\SimpleRouter\Handlers\EventHandler;
use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{
    public static function start(): void
    {
        // Load helpers
        require_once 'helpers.php';
        // Load custom routes
        require_once '../routes/web.php';
        // Create php-di container
        $container = (new \DI\ContainerBuilder())
            ->addDefinitions(include 'dependency.php')
            ->useAutowiring(true)
            ->build();

        parent::enableDependencyInjection($container);

        $eventHandler = new EventHandler();

        // Add event that fires when a route is rendered
        $eventHandler->register(EventHandler::EVENT_RENDER_ROUTE, static function (EventArgument $argument) {

            // Get the route by using the special argument for this event.
            $route = $argument->route;
            // If Api request
            if ($route->getName() === '.message' && !$argument->getRequest()->user->isAuthorized($route->getIdentifier())) {
                throw new \Exception('Unauthorized', 401);
            }
        });

        parent::addEventHandler($eventHandler);
        parent::start();
    }
}