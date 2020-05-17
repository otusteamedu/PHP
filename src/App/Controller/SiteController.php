<?php

namespace App\Controller;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SiteController
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        ob_start();
        phpinfo();
        $content = ob_get_clean();

        $response = new Response();
        $response = $response->withStatus(200);
        $response->getBody()->write($content);

        return $response;
    }
}
