<?php


namespace Otushw;

use Exception;


class Youtube
{
    const URL_API = 'https://www.googleapis.com/youtube/v3';
    const MAX_NUMBER_VIDEOS = 50;

    private $channelId;
    private $apiKey;
    private $listVideosID = [];
    private $pageToken = '';

    public function __construct()
    {
        $this->channelId = $_ENV['CHANNEL_ID'];
        $this->apiKey = $_ENV['YOUTUBE_API_KEY'];
    }

    public function getListVideosID()
    {
        $params = [
            'part' => 'snippet,id',
            'order' => 'date',
            'maxResults' => self::MAX_NUMBER_VIDEOS
        ];
        if (!empty($this->pageToken)) {
            $params['pageToken'] = $this->pageToken;
        }
        $url = $this->generateURL('search', $params);

        $response = $this->request($url);
        if (empty($response['items'])) {
            $this->listVideosID = [];
            return;
        }

        $videosID = [];
        foreach ($response['items'] as $item) {
            $videosID[] = $item['id']['videoId'];
        }
        $this->listVideosID = $videosID;
        $this->pageToken = $response['nextPageToken'];
    }

    public function getVideo()
    {
        $videoID = $this->getLastVideoID();
        if (empty($videoID)) {
            return false;
        }
        $params = [
            'fields' => 'items(id,snippet(channelId,title,categoryId),statistics)',
            'part' => 'snippet,statistics',
            'id' => $videoID
        ];
        $url = $this->generateURL('videos', $params);
        $response = $this->request($url);
        if (empty($response['items'])) {
            throw new Exception('1111YouTube returned an unsupported data structure.');
        }
        $response = $response['items'][0];
        foreach (['snippet', 'statistics'] as $item) {
            if (empty($response[$item])) {
                throw new Exception('22222YouTube returned an unsupported data structure.');
            }
        }
        return [
            'id' => $videoID,
            'title' => $response['snippet']['title'],
            'viewCount' => $response['statistics']['viewCount'],
            'likeCount' => $response['statistics']['likeCount'],
            'dislikeCount' => $response['statistics']['dislikeCount'],
            'commentCount' => $response['statistics']['commentCount'],
        ];
    }

    public function getNumberListVideo()
    {
        return count($this->listVideosID);
    }

    /**
     * @return bool|string
     */
    private function getLastVideoID()
    {
        $videoID = array_pop($this->listVideosID);
        if (empty($videoID)) {
            return false;
        }
        return $videoID;
    }

    /**
     * @param string $operation
     * @param array $params
     *
     * @return string
     */
    private function generateURL($operation, array $params)
    {
        $params['key'] = $this->apiKey;
        $params['channelId'] = $this->channelId;
        return self::URL_API . '/' . $operation  . '/?' . http_build_query($params);
    }

    /**
     * @param string $url
     *
     * @return bool|string
     * @throws Exception
     */
    private function request($url)
    {
        $response = $this->sendRequest($url);
        return $this->validateRequest($response);
    }

    /**
     * @param string $url
     *
     * @return bool|string
     */
    private function sendRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @param mixed $response
     *
     * @throws Exception
     *
     * @return bool|string
     */
    private function validateRequest($response)
    {
        if (empty($response)) {
            throw new Exception('YouTube is not available.');
        }
        $response = json_decode($response, true);
        if (empty($response)) {
            throw new Exception('YouTube returned data not in format is not JSON.');
        }

        return $response;
    }
}