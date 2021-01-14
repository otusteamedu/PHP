<?php

namespace VideoPlatform\platforms;

use GuzzleHttp\Exception\GuzzleException;
use VideoPlatform\interfaces\VideoSharingPlatformInterface;
use VideoPlatform\services\YoutubeService;
use VideoPlatform\traits\RequestTrait;

class Youtube implements VideoSharingPlatformInterface
{
    use RequestTrait;

    private $apiKey;
    private $clientSecret;
    private $baseUrl = 'https://youtube.googleapis.com/youtube/v3';

    private $service;

    public function __construct()
    {
        $config = $this->getConfig();

        $this->apiKey = $config['api_key'];
        $this->clientSecret = $config['client_secret'];

        $this->service = new YoutubeService();
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'api_key' => $_ENV['YOUTUBE_API_KEY'],
            'client_secret' => $_ENV['YOUTUBE_CLIENT_SECRET']
        ];
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getChannelDetail(): array
    {
        $url = $this->baseUrl . '/channels?part=snippet,contentDetails,statistics' . '&id=' . $_SERVER['argv'][1]
            . '&key=' . $this->apiKey;

        $data = $this->sendRequest('GET', $url);

        if (empty($data['items'])) {
            throw new \Exception('not found');
        }

        return $data['items'];
    }

    public function getVideos($channelId, $nextPageToken = ''): array
    {
        $url = $this->baseUrl . '/search?channelId=' . $channelId . '&part=snippet&order=date&maxResults=50' .
            '&key=' . $this->apiKey;

        if (!empty($nextPageToken)) $url .= '&pageToken=' . $nextPageToken;

        return $this->sendRequest('GET', $url);
    }

    public function getVideoDetail($channelId): array
    {
        $url = $this->baseUrl . '/videos?part=snippet,statistics&id=' . $channelId . '&key=' . $this->apiKey;

        $data = $this->sendRequest();
    }

    /**
     * 1. Получить данные канала
     * 2. Получить видео этого канала
     * 3. Сохранить данные используя модель
     * @throws GuzzleException
     */
    public function analyze()
    {
        $channelDetails = $this->getChannelDetail();


        foreach ($channelDetails as $channel) {
            $this->service->saveChannelDetails($channel);

            $videos = $this->getVideos($channel['id']);

            while (!empty($videos['nextPageToken'])) {
                break;
//                $this->save();
//                $videos = $this->getVideos($channel['id'], $videos['nextPageToken']);
            }

            $this->service->saveChannelVideos();
        }
    }

    public function getChannelById($id)
    {
        return $this->service->getChannelById($id);
    }
}
