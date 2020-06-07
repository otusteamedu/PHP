<?php

namespace App\Action;

use App\Api\ActionInterface;
use App\Api\RequestInterface;
use App\Api\ResponseInterface;
use App\Api\ViewInterface;
use App\View;

class Index implements ActionInterface
{

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ViewInterface
     */
    public function execute(RequestInterface $request, ResponseInterface $response): ViewInterface
    {
        return (new View('index'));
    }
}