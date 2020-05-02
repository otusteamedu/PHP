<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Http\Forms\VideoForm;
use Bjlag\Mappers\ChannelMapper;
use Bjlag\Mappers\VideoMapper;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoController extends BaseController
{
    /** @var \Bjlag\Mappers\VideoMapper */
    private $videoMapper;

    /**
     * VideoController constructor.
     */
    public function __construct()
    {
        $this->videoMapper = new VideoMapper();
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->videoMapper->with(ChannelMapper::class);
        $videos = $this->videoMapper->find();

        return $this->getResponseHtml('video/index', [
            'videos' => $videos
        ]);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $form = (new VideoForm($request->getParsedBody()))->fillAndValidate();
        $videoEntity = VideoMapper::create($form);

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $this->videoMapper->save($videoEntity),
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

        $videoEntity = $this->videoMapper->findById($rawData['filter']['id']);
        if ($videoEntity === null) {
            throw new NotFoundException('Видео не найден');
        }

        $form = (new VideoForm($rawData['data']))->fillAndValidate();

        $videoEntity
            ->setChannelId($form->getChannelId())
            ->setUrl($form->getUrl())
            ->setName($form->getName())
            ->setPreviewImage($form->getPreviewImage())
            ->setDescription($form->getDescription())
            ->setCategory($form->getCategory())
            ->setDuration($form->getDuration())
            ->setPostData($form->getPostData())
            ->setNumberLike($form->getNumberLike())
            ->setNumberDislike($form->getNumberDislike())
            ->setNumberViews($form->getNumberViews());

        return $this->getResponseJson([
            'is_succeed' => (bool) $this->videoMapper->save($videoEntity),
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\NotFoundException
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        if (!isset($rawData['filter']['id'])) {
            throw new BadRequestException();
        }

        $videoEntity = $this->videoMapper->findById($rawData['filter']['id']);
        if ($videoEntity === null) {
            throw new NotFoundException('Видео не найден');
        }

        return $this->getResponseJson([
            'is_succeed' => $this->videoMapper->delete($videoEntity),
        ], 200);
    }
}
