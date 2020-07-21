<?php

namespace App\Controllers;

use Classes\Dto\VideoDtoBuilder;
use Classes\Repositories\YoutubeVideoRepository;

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


       $this->youtubeVideoService->create($videoDto);

        $test = 1;

        return $response;
    }

    public function deleteVideo()
    {
        $videoRepository = new YoutubeVideoRepository();
        $test = 1;
    }
}
