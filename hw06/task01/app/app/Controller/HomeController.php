<?php
// app/Controller/HomeController.php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment as Render;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController
{

    /**
     * @var Render
     */
    private $render;

    public function __construct(Render $render)
    {
        $this->render = $render;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response)
    {

        $response->getBody()->write(
            $this->render->render('form.twig', [])
        );
        return $response;
    }
}