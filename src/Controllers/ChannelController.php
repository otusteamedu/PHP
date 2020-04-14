<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Channel;
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
        $channels = Channel::find();

        return $this->getResponseHtml('channel/index', ['channels' => $channels]);
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

        return $this->getResponseJson([
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
        $modifiedCount = Channel::update($data['filter'], $data['data']);

        return $this->getResponseJson([
            'is_succeed' => true,
            'modified_count' => $modifiedCount
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $deletedCount = Channel::delete($data['filter']);

        return $this->getResponseJson([
            'is_succeed' => true,
            'deleted_count' => $deletedCount
        ], 200);
    }
}
