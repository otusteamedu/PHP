<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SecurityController extends AbstractController
{
    /**
     * Форма входа пользователей. После успешного входа, перенаправление на страницу профиля.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function login(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            list($email, $password) = array_values($request->getParsedBody());

            if ($this->security->login($email, $password)) {
                return $response
                    ->withHeader('Location', '/profile')
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

    /**
     * Выход пользователя. Перенаправление на главную страницу.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout(Request $request, Response $response): Response
    {
        $this->security->logout();
        return $response
            ->withHeader('Location', '/');
    }

}
