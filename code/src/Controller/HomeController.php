<?php

namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends AbstractController
{

    public function index(Request $request, Response $response): Response
    {
        $result = 'ДЗ';

        return $this->render($response, 'home/index.php', [
            'result' => $result,
            ]);
    }
}
