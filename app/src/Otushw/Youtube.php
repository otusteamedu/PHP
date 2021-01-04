<?php


namespace Otushw;


class Youtube
{
    const URL_API = 'https://www.googleapis.com/youtube/v3';
    const MAX_NUMBER_VIDEOS = 20;

    private $channelId;
    private $apiKey;

    public function __construct()
    {
        $this->channelId = $_ENV['CHANNEL_ID'];
        $this->apiKey = $_ENV['YOUTUBE_API_KEY'];
    }

    public function getListVideos()
    {
        $params = [
            'part' => 'snippet,id',
            'order' => 'date',
            'maxResults' => self::MAX_NUMBER_VIDEOS
        ];
        $url = $this->generateURL('search', $params);
        var_dump($url);
        $response = $this->sendRequest($url);
        var_dump($response);
    }

    private function generateURL($operation, array $params)
    {
        $params['key'] = $this->apiKey;
        $params['channelId'] = $this->channelId;
        return self::URL_API . '/' . $operation  . '/?' . http_build_query($params);
    }

    private function sendRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}