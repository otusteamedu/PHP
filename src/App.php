<?php declare(strict_types=1);

use Service\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(): Response
    {
        $request = Request::createFromGlobals();
        try {
            $controller = $this->router->handleRequest($request);
            $response = call_user_func($controller, $request);
            if (!$response instanceof Response) {
                throw new LogicException(sprintf('The controller must return a response (%s given).', var_export($response, true)), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Throwable $exception) {
            $response = new Response($exception->getMessage(), $exception->getCode());
        }

        return $response->send();
    }
}
