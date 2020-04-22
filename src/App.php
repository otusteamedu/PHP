<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Service\Router;

class App
{

    public function run(): Response
    {
        $request = Request::createFromGlobals();
        $router = new Router();

        try {
            $controller = $router->dispatch($request);
            $response = call_user_func($controller, $request);
        } catch (Throwable $exception) {
            $response = new Response(htmlspecialchars($exception->getMessage()), $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->send();
    }
}