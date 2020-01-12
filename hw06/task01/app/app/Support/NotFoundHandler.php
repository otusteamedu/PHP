<?php
// app/Support/NotFoundHandler.php

namespace App\Support;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NotFoundHandler implements ErrorHandlerInterface
{

    private $factory;

    private $render;

    public function __construct(ResponseFactoryInterface $factory, Environment $render)
    {
        $this->factory = $factory;
        $this->render = $render;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): ResponseInterface
    {
        $response = $this->factory->createResponse(404);
        $response->getBody()->write($this->render->render('err404.twig'));
        return $response;
    }
}