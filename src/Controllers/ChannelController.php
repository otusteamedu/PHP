<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Channel;
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
        $rows = Channel::find();

        ob_start();
        var_dump($rows);
        $content = ob_get_contents();

        $response = new Response();
        $response->getBody()->write($content);

        return $response;
    }

    /**
     * Добавление нового канала.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Laminas\Diactoros\Response\JsonResponse
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $id = Channel::add($request->getParsedBody());

        return new Response\JsonResponse([
            'is_succeed' => true,
            'id' => $id,
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        Channel::update($data['filter'], $data['data']);

        return new Response\JsonResponse([
            'is_succeed' => true,
        ], 200);
    }

    public function deleteAction()
    {
    }
}
