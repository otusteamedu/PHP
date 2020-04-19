<?php

namespace Bjlag;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

abstract class BaseController
{
    protected function getResponseSimple(string $content, int $status = 200): ResponseInterface
    {
        $response = (new Response())->withStatus($status);
        $response->getBody()->write($content);

        return $response;
    }

    /**
     * @param array $data
     * @param int $status
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function getResponseJson(array $data, int $status = 200): ResponseInterface
    {
        return new Response\JsonResponse($data, $status);
    }
}
