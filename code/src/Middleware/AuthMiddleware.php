<?php


namespace App\Middleware;


use App\DTO\ForbiddenDTO;
use App\Service\Security\SecurityInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * Class AuthMiddleware
 * @package App\Middleware
 */
class AuthMiddleware
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
     * Защита приватных маршрутов. Проверяет токен пользователя.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Slim\Psr7\Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            $header = $request->getHeader('Authorization');
            list (, $token) = explode(' ', $header[0]);

            if (! $token) {
                throw new \Exception();
            }

            if(! $this->security->getIdentity($token) ) {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            $forbidden = new ForbiddenDTO();
            $response = new Response();
            $response->getBody()->write(json_encode($forbidden));

            return $response
                ->withStatus($forbidden->getStatusCode());
        }


        return $handler->handle($request);
    }

}
