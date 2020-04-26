<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Dto\VideoDto;
use Bjlag\Models\Video;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\UnprocessableEntityException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoController extends BaseController
{
    /** @var \Bjlag\Models\Video */
    private $videoModel;

    /**
     * VideoController constructor.
     */
    public function __construct()
    {
        $this->videoModel = new Video();
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $rows = $this->videoModel->find();

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
        $rawData = $request->getParsedBody();

        $requiredFields = [
            Video::FIELD_CHANNEL_ID,
            Video::FIELD_URL,
            Video::FIELD_NAME,
            Video::FIELD_PREVIEW_IMAGE,
            Video::FIELD_DESCRIPTION,
            Video::FIELD_CATEGORY,
            Video::FIELD_DURATION,
            Video::FIELD_POST_DATA,
            Video::FIELD_NUMBER_LIKE,
            Video::FIELD_NUMBER_DISLIKE,
            Video::FIELD_NUMBER_VIEWS,
        ];

        $video = $this->getVideoDto($rawData, $requiredFields);

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $this->videoModel->add($video),
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function editAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        if (!isset($rawData['filter']['id']) || !isset($rawData['data'])) {
            throw new BadRequestException();
        }

        $requiredFields = [
            Video::FIELD_CHANNEL_ID,
            Video::FIELD_URL,
            Video::FIELD_NAME,
            Video::FIELD_PREVIEW_IMAGE,
            Video::FIELD_DESCRIPTION,
            Video::FIELD_CATEGORY,
            Video::FIELD_DURATION,
            Video::FIELD_POST_DATA,
            Video::FIELD_NUMBER_LIKE,
            Video::FIELD_NUMBER_DISLIKE,
            Video::FIELD_NUMBER_VIEWS,
        ];

        $video = $this->getVideoDto($rawData['data'], $requiredFields);

        return $this->getResponseJson([
            'is_succeed' => true,
            'modified_count' => $this->videoModel->update($rawData['filter'], $video)
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\BadRequestException
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $rawData = $request->getParsedBody();

        if (!isset($rawData['filter']['id'])) {
            throw new BadRequestException();
        }

        return $this->getResponseJson([
            'is_succeed' => true,
            'deleted_count' =>  $this->videoModel->delete($rawData['filter'])
        ], 200);
    }

    /**
     * @param array $rawData
     * @param array $requiredFields
     * @return \Bjlag\Models\Dto\VideoDto
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    private function getVideoDto(array $rawData, array $requiredFields): VideoDto
    {
        $video = new VideoDto();

        foreach ($requiredFields as $field) {
            if (!isset($rawData[$field])) {
                throw new UnprocessableEntityException("Поле '{$field}' обязательно для заполнения.");
            }

            $setterName = strtr($field, ['_' => ' ']);
            $setterName = ucwords($setterName);
            $setterName = 'set' . strtr($setterName, [' ' => '']);

            $video->{$setterName}($rawData[$field]);
        }

        return $video;
    }
}
