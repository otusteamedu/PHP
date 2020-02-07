<?php declare(strict_types=1);

use Service\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    public function run(Request $request): Response
    {
        $router = new Router();
        try {
            $controller = $router->handleRequest($request);

            return call_user_func($controller, $request);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
