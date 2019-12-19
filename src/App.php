<?php

declare(strict_types=1);

use Service\Router;

class App
{
    /**
     * @param array $args
     * @throws Exception
     */
    public function run(array $args): void
    {
        $router = new Router();
        $controller = $router->resolveCommand($args[1]);
        $controller->run($args[2] ?? null);
    }
}
