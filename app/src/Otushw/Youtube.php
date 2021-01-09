<?php


namespace Otushw;

use Exception;

class Youtube
{
    const URL_API = 'https://www.googleapis.com/youtube/v3';
    const MAX_NUMBER_VIDEOS = 4;

    private string $channelId;
    private string $apiKey;
    private array $listVideosID = [];
    private string $pageToken = '';

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
            if (!empty($item['id']['videoId'])) {
                $videosID[] = $item['id']['videoId'];
            }
        }
        $this->listVideosID = $videosID;
        $this->pageToken = $response['nextPageToken'];
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function getVideo(): array
    {
        $videoID = $this->getLastVideoID();
        if (empty($videoID)) {
            return [];
        }
        $params = [
            'fields' => 'items(id,snippet(channelId,title,categoryId),statistics)',
            'part' => 'snippet,statistics',
            'id' => $videoID
        ];
        $url = $this->generateURL('videos', $params);
        $response = $this->request($url);
        if (empty($response['items'])) {
            throw new Exception('YouTube returned an unsupported data structure.');
        }
        $response = $response['items'][0];
        foreach (['snippet', 'statistics'] as $item) {
            if (empty($response[$item])) {
                throw new Exception('YouTube returned an unsupported data structure.');
            }
        }
        return [
            'id' => $videoID,
            'title' => $response['snippet']['title'],
            'viewCount' => intval($response['statistics']['viewCount']),
            'likeCount' => intval($response['statistics']['likeCount']),
            'disLikeCount' => intval($response['statistics']['dislikeCount']),
            'commentCount' => intval($response['statistics']['commentCount']),
        ];
    }

    /**
     * @return int
     */
    public function getNumberListVideo(): int
    {
        return count($this->listVideosID);
    }

    /**
     * @return string
     */
    private function getLastVideoID(): string
    {
        $videoID = array_pop($this->listVideosID);
        if (empty($videoID)) {
            return '';
        }
        return $videoID;
    }

    /**
     * @param string $operation
     * @param array $params
     *
     * @return string
     */
    private function generateURL($operation, array $params): string
    {
        $params['key'] = $this->apiKey;
        $params['channelId'] = $this->channelId;
        return self::URL_API . '/' . $operation  . '/?' . http_build_query($params);
    }

    /**
     * @param string $url
     *
     * @return array
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
     * @return string
     */
    private function sendRequest($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if (empty($response)) {
            $response = '';
        }
        curl_close($ch);
        return $response;
    }

    /**
     * @param mixed $response
     *
     * @throws Exception
     *
     * @return array
     */
    private function validateRequest($response): array
    {
        if (empty($response)) {
            throw new Exception('YouTube is not available.');
        }
        $response = json_decode($response, true);
        if (empty($response)) {
            $response = [];
        }
        if (empty($response)) {
            throw new Exception('YouTube returned data not in format is not JSON.');
        }
        return $response;
    }
}
