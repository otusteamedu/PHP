<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Http\Forms\ChannelForm;
use Bjlag\Mappers\ChannelMapper;
use Bjlag\Services\StatisticsService;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChannelController extends BaseController
{
    /** @var \Bjlag\Mappers\ChannelMapper */
    private $channelMapper;

    /** @var \Bjlag\Services\StatisticsService */
    private $statisticsService;

    /**
     * @param \Bjlag\Mappers\ChannelMapper $mapper
     * @param \Bjlag\Services\StatisticsService $service
     */
    public function __construct(ChannelMapper $mapper, StatisticsService $service)
    {
        $this->channelMapper = $mapper; // new ChannelMapper();
        $this->statisticsService = $service; // StatisticsService();
    }

    /**
     * Вывод всех каналов из БД.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $channels = $this->channelMapper->find();
        $topIds = $this->statisticsService->getTop5Channels()->getChannelIds();

        return $this->getResponseHtml('channel/index', [
            'channels' => $channels,
            'top' => $this->channelMapper->findByIds($topIds),
        ]);
    }

    /**
     * Вывод подробной информации о канале.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param array $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\NotFoundException
     */
    public function viewAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        if (!isset($args['id'])) {
            throw new BadRequestException();
        }

        $channel = $this->channelMapper->findById($args['id']);
        if ($channel === null) {
            throw new NotFoundException('Канал не найден');
        }

        $statistics = $this->statisticsService->calcTotalLikesAndDislikesByChannelId($channel->getId());

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
        $form = (new ChannelForm($request->getParsedBody()))->fillAndValidate();
        $channelEntity = ChannelMapper::create($form);

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $this->channelMapper->save($channelEntity),
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

        $channelEntity = $this->channelMapper->findById($rawData['filter']['id']);
        if ($channelEntity === null) {
            throw new NotFoundException('Канал не найден');
        }

        $form = (new ChannelForm($rawData['data']))->fillAndValidate();

        $channelEntity
            ->setUrl($form->getUrl())
            ->setName($form->getName())
            ->setDescription($form->getDescription())
            ->setBanner($form->getBanner())
            ->setCountry($form->getCountry())
            ->setRegistrationData($form->getRegistrationData())
            ->setNumberViews($form->getNumberViews())
            ->setNumberSubscribes($form->getNumberSubscribes())
            ->setLinks($form->getLinks());

        return $this->getResponseJson([
            'is_succeed' => (bool) $this->channelMapper->save($channelEntity),
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\NotFoundException
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        if (!isset($rawData['filter']['id'])) {
            throw new BadRequestException();
        }

        $channelEntity = $this->channelMapper->findById($rawData['filter']['id']);
        if ($channelEntity === null) {
            throw new NotFoundException();
        }

        return $this->getResponseJson([
            'is_succeed' => $this->channelMapper->delete($channelEntity),
        ], 200);
    }
}
