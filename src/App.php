<?php

declare(strict_types=1);

namespace HomeWork;

use HomeWork\Service\Router;
use Throwable;

class App
{
    public function run(array $args): void
    {
        $router = new Router();
        try {
            $controller = $router->resolveCommand($args[1]);
            $controller->run($args[2] ?? null);
        } catch (Throwable $exception) {
            http_response_code($exception->getCode());
            printf('Fatal error: %s', $exception->getMessage());
        }
    }
}
