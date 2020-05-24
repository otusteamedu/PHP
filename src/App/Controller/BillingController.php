<?php

namespace App\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BillingController
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function payAction(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($request->getParsedBody(), 200);
    }
}
