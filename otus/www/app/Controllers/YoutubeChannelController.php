<?php

namespace App\Controllers;


use Classes\Dto\ChannelDtoBuilder;
use Services\YoutubeChannelServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class YoutubeChannelController
{
    private $youtubeChannelService;

    public function __construct(YoutubeChannelServiceInterface $youtubeChannelService)
    {
       $this->youtubeChannelService = $youtubeChannelService;
    }

    public function createChannel(Request $request, Response $response, $args)
    {

        $requestData = $request->getParsedBody();
        $channelDtoBuilder = new ChannelDtoBuilder();

        try {
            $channelDto = $channelDtoBuilder
                ->setChannelId($requestData['channelId'])
                ->setChannelName($requestData['channelName'])
                ->setChannelVideoIds($requestData['videosIds'])
                ->build()
            ;
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        try {
            $this->youtubeChannelService->create($channelDto);
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        $response->getBody()->write('Канал добавлен успешно');
        return $response;
    }

    public function deleteChannelById(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();

        if (!isset($requestData['channelId']) || empty($requestData['channelId'])) {
            $response->getBody()->write('Не передан id удаляемого канала');
            return $response;
        }

        try {
            $this->youtubeChannelService->deleteById($requestData['channelId']);
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        $response->getBody()->write(sprintf('Канал c id %s успешно удален', $requestData['channelId']));
        return $response;
    }
}
