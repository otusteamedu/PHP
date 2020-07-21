<?php

namespace App\Controllers;

use Classes\Dto\VideoDtoBuilder;
use Services\YoutubeVideoServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


class YoutubeVideoController
{
    private $youtubeVideoService;

    public function __construct(YoutubeVideoServiceInterface $youtubeVideoService )
    {
        $this->youtubeVideoService = $youtubeVideoService;

    }

    public function createVideo(Request $request, Response $response, $args)
    {
       $requestData = $request->getParsedBody();
       $videoDtoBuilder = new VideoDtoBuilder();

       try {
           $videoDto = $videoDtoBuilder
               ->setVideoId($requestData['videoId'] ?? null)
               ->setChannelId($requestData['channelId'] ?? null)
               ->setVideoName($requestData['videoName'] ?? null)
               ->setVideoDislikeCount($requestData['videoDislikeCount'] ?? null)
               ->setVideoLikeCount($requestData['videoLikeCount'] ?? null)
               ->build()
           ;
       } catch (\Exception $exception) {
         $response->getBody()->write($exception->getMessage());
         return $response;
       }

       try {
           $this->youtubeVideoService->create($videoDto);
       } catch (\Exception $exception) {
           $response->getBody()->write($exception->getMessage());
           return $response;
       }

        $response->getBody()->write('Видео добавлено успешно');
        return $response;
    }

    public function deleteVideoById(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();

        if (!isset($requestData['videoId']) || empty($requestData['videoId'])) {
            $response->getBody()->write('Не передан id удаляемого видео');
            return $response;
        }

       try {
           $this->youtubeVideoService->deleteById($requestData['videoId']);
       } catch (\Exception $exception) {
           $response->getBody()->write($exception->getMessage());
           return $response;
       }

        $response->getBody()->write(sprintf('Видео c id %s успешно удалено', $requestData['videoId']));
        return $response;
    }
}
