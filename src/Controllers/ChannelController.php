<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Helpers\DataHelpers;
use Bjlag\Models\Channel;
use Bjlag\Models\Dto\ChannelDto;
use Bjlag\Services\StatisticsService;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnprocessableEntityException;
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
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        $requiredFields = [
            Channel::FIELD_URL,
            Channel::FIELD_NAME,
            Channel::FIELD_DESCRIPTION,
            Channel::FIELD_BANNER,
            Channel::FIELD_COUNTRY,
            Channel::FIELD_REGISTRATION_DATA,
            Channel::FIELD_NUMBER_VIEWS,
            Channel::FIELD_NUMBER_SUBSCRIBES,
            Channel::FIELD_LINKS,
        ];

        $channel = $this->getChannelDto($rawData, $requiredFields);

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $this->channelModel->add($channel),
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\NotFoundException
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function editAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        if (!isset($rawData['filter']['id']) || !isset($rawData['data'])) {
            throw new BadRequestException();
        }

        if (empty($this->channelModel->findById($rawData['filter']['id']))) {
            throw new NotFoundException('Канал не найден');
        }

        $requiredFields = [
            Channel::FIELD_URL,
            Channel::FIELD_NAME,
            Channel::FIELD_DESCRIPTION,
            Channel::FIELD_BANNER,
            Channel::FIELD_COUNTRY,
            Channel::FIELD_REGISTRATION_DATA,
            Channel::FIELD_NUMBER_VIEWS,
            Channel::FIELD_NUMBER_SUBSCRIBES,
            Channel::FIELD_LINKS,
        ];

        $channel = $this->getChannelDto($rawData['data'], $requiredFields);
        $modifiedCount = $this->channelModel->update($rawData['filter'], $channel);

        return $this->getResponseJson([
            'is_succeed' => (bool) $modifiedCount,
            'modified_count' => $modifiedCount,
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

    /**
     * @param array $rawData
     * @param array $requiredFields
     *
     * @return \Bjlag\Models\Dto\ChannelDto
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    private function getChannelDto(array $rawData, array $requiredFields): ChannelDto
    {
        try {
            /** @var ChannelDto $result */
            $result = DataHelpers::fillDto(new ChannelDto(), $rawData, $requiredFields);
            return $result;
        } catch (\InvalidArgumentException $e) {
            throw new UnprocessableEntityException($e->getMessage());
        }
    }
}
