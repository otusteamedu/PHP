<?php


namespace App\Controllers;


use App\Messages\MessageWeb;
use App\Repositories\ChannelRepository;
use App\Services\YoutubeApiService;
use GuzzleHttp\Client;
use Klein\Request;

/**
 * Class YoutubeController
 * @package App\Controllers
 */
class YoutubeController
{
    public function spider()
    {
        $client = new Client();

        $youtubeApiService = new YoutubeApiService($client);

        $channelRepository = new ChannelRepository();

        $query = 'main';

        $channels = $youtubeApiService->getJsonChannels($query, 'https://www.googleapis.com/youtube/v3/search');

        $channelRepository->insertMany($channels);

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'Ok'], JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    public function deleteChannels()
    {
        $channelRepository = new ChannelRepository();

        $channelRepository->deleteAll();

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'Ok'], JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    public function getTopChannels(Request $request)
    {
        $channelRepository = new ChannelRepository();

        $limit = $request->param('limit')?:5;

        $data = $channelRepository->getTopChannels($limit);

        try {
            return MessageWeb::sendOk(json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

    }


    public function getStatisticsChannelVideos()
    {
        $channelRepository = new ChannelRepository();

        $data = $channelRepository->getStatisticsSum();

        try {
            return MessageWeb::sendOk(json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

    }

}