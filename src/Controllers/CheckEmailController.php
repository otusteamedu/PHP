<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CheckEmailController
{
    public function process(RequestInterface $request): ResponseInterface
    {
        return new \Nyholm\Psr7\Response(200, [], 'Check email');
    }
}
