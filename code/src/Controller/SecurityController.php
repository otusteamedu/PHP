<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SecurityController extends AbstractController
{
    public function login(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            list($email, $password) = array_values($request->getParsedBody());

            if ($this->security->login($email, $password)) {
                return $response
                    ->withHeader('Location', '/')
                    ->withStatus(302);
            } else {
                $error = 'Неверный логин или пароль';
            }
        }

        return $this->render($response, 'security/login.php', [
            'error' => $error ?? null,
            'email' => $email ?? null,
        ]);
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->security->logout();
        return $response
            ->withHeader('Location', '/');
    }

}
