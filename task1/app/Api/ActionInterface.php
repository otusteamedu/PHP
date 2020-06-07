<?php

namespace App\Api;

interface ActionInterface
{
    public function execute(RequestInterface $request, ResponseInterface $response): ViewInterface;
}