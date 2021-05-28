<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends AbstractController
{
    public function profile(Request $request, Response $response): Response
    {
        return $this->render($response, 'user/index.php', [
            'data' => $data ?? null
        ]);
    }

}
