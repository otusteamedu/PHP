<?php declare(strict_types=1);

use Service\Router;

class AppConsole
{
    public function run(array $args): void
    {
        $router = new Router();
        $controller = $router->resolveCommand($args[1]);
        call_user_func($controller, array_slice($args, 2));
    }
}
