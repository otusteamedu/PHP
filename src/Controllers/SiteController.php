<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SiteController extends BaseController
{
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getResponseJson([
            'API' => '1.0.0',
        ]);
    }
}
