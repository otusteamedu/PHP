<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SiteController extends BaseController
{
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($this->render('site/index.twig'));

        return $response;
    }
}
