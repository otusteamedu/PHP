<?php


namespace App\Middleware;

use App\Service\Security\SecurityInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class SecurityMiddleware
{
    private SecurityInterface $security;

    /**
     * SecurityMiddleware constructor.
     * @param \App\Service\Security\SecurityInterface $security
     */
    public function __construct(SecurityInterface $security)
    {
        $this->security = $security;
    }


    /**
     * Защита приватных маршрутов. Проверяет вошел ли пользователь.
     * В случае отрицательного результата, перенаправляет пользователя на страницу входа.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Slim\Psr7\Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (null === $this->security->getIdentity()) {
            $response = new Response();

            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        return $handler->handle($request);
    }

}
