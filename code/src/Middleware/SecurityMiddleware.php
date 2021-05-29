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


    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if (! $this->security->getIdentity()) {
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        return $response;
    }

}
