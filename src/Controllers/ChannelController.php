<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Channel;
use Bjlag\Services\StatisticsService;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChannelController extends BaseController
{
    /** @var \Bjlag\Models\Channel */
    private $channelModel;

    /** @var \Bjlag\Services\StatisticsService */
    private $statisticsService;

    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->channelModel = new Channel();
        $this->statisticsService = new StatisticsService();
    }

    /**
     * Вывод всех каналов из БД.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $channels = $this->channelModel->find();
        $topIds = $this->statisticsService->getTop5Channels()->getChannelIds();

        return $this->getResponseHtml('channel/index', [
            'channels' => $channels,
            'top' => $this->channelModel->findByIds($topIds),
        ]);
    }

    /**
     * Вывод подробной информации о канале.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\NotFoundException
     */
    public function viewAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id = $args['id'] ?? null;
        if ($id !== null) {
            $channel = $this->channelModel->findById($id);
        }

        if (empty($channel)) {
            throw new NotFoundException('Канал не найден');
        }

        $statistics = $this->statisticsService->calcTotalLikesAndDislikesByChannelId($id);

        $data['channel'] = $channel;
        $data['statistics'] = [
            'like_total' => $statistics->getLikesTotal(),
            'dislike_total' => $statistics->getDislikesTotal(),
        ];

        return $this->getResponseHtml('channel/view', $data);
    }

    /**
     * Добавление нового канала.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Laminas\Diactoros\Response\JsonResponse
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $id = $this->channelModel->add($request->getParsedBody());

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
        $modifiedCount = $this->channelModel->update($data['filter'], $data['data']);

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
        $deletedCount = $this->channelModel->delete($data['filter']);

        return $this->getResponseJson([
            'is_succeed' => true,
            'deleted_count' => $deletedCount
        ], 200);
    }
}
