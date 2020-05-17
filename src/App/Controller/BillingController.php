<?php

namespace App\Controller;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BillingController
{
    public function paidAction(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse('paid', 200);
    }
}
