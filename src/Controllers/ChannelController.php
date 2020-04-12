<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChannelController extends BaseController
{
    /**
     * Вывод всех каналов из БД.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Доступные каналы');

        return $response;
    }

    public function addAction()
    {
        return new Response\JsonResponse([
            'is_succeed' => true,
            'id' => 1,
        ], 200);
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}
