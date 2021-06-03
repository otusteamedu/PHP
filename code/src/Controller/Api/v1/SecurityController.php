<?php


namespace App\Controller\Api\v1;


use App\Controller\Api\AbstractController;
use App\DTO\ForbiddenDTO;
use App\DTO\TokenDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SecurityController extends AbstractController
{
    /**
     * Вход пользователей. После успешного входа, создаётся токен.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function login(Request $request, Response $response): Response
    {
        list ($email, $password) = array_values($request->getParsedBody());

        $token = $this->security->login($email, $password);

        $data = $token ? new TokenDTO($token) : new ForbiddenDTO();

        return $this->jsonResponse($response, $data);
    }
}
