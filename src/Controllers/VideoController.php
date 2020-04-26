<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Entities\VideoEntity;
use Bjlag\Http\Forms\VideoForm;
use Bjlag\Repositories\VideoRepository;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoController extends BaseController
{
    /** @var \Bjlag\Entities\VideoEntity */
    private $videoModel;

    /** @var \Bjlag\Repositories\VideoRepository */
    private $videoRepository;

    /**
     * VideoController constructor.
     */
    public function __construct()
    {
        $this->videoModel = new VideoEntity();
        $this->videoRepository = new VideoRepository();
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $rows = $this->videoRepository->find();

        ob_start();
        var_dump($rows);
        $content = ob_get_contents();

        return $this->getResponseSimple($content, 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $form = (new VideoForm($request->getParsedBody()))->fillAndValidate();
        $videoEntity = VideoEntity::create($form);

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $videoEntity->save(),
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

        $videoEntity = $this->videoRepository->findById($rawData['filter']['id']);
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
            'is_succeed' => (bool) $videoEntity->save(),
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

        $videoEntity = $this->videoRepository->findById($rawData['filter']['id']);
        if ($videoEntity === null) {
            throw new NotFoundException('Видео не найден');
        }

        return $this->getResponseJson([
            'is_succeed' => $videoEntity->delete(),
        ], 200);
    }
}
