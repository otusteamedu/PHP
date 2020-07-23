<?php

namespace App\Controllers;

use Classes\Dto\ChannelDtoBuilder;
use Classes\ResponseHandler;
use Services\YoutubeChannelServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class YoutubeChannelCrudController
{
    private $youtubeChannelService;

    public function __construct
    (
        YoutubeChannelServiceInterface $youtubeChannelService
    )
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
            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
            return $response;
        }

        try {
            $this->youtubeChannelService->create($channelDto);
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response;
        }

        $result = [
            'success' => true,
            'message' => 'Канал добавлен успешно'
        ];

        $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
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
            $result = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR, 512));
            return $response;
        }

        $result = [
            'success' => true,
            'message' => sprintf('Канал c id %s успешно удален', $requestData['channelId'])
        ];

        $response->getBody()->write(ResponseHandler::getControllerResponseData($result));
        return $response;
    }
}
