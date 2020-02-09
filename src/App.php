<?php declare(strict_types=1);

use Service\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    public function run(): Response
    {
        $request = Request::createFromGlobals();
        $router = new Router();
        try {
            $controller = $router->handleRequest($request);
            $response = call_user_func($controller, $request);
        } catch (Throwable $exception) {
            $response = new Response($exception->getMessage(), $exception->getCode());
        }

        return $response->send();
    }
}
