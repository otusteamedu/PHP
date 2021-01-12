<?php


namespace Otushw;

use Otushw\AppException;

class Youtube
{
    const URL_API = 'https://www.googleapis.com/youtube/v3';
    const MAX_NUMBER_VIDEOS = 50;

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
     * @return VideoDTO
     *
     * @throws AppException
     */
    public function getVideo(): ?VideoDTO
    {
        $videoID = $this->getLastVideoID();
        if (empty($videoID)) {
            return null;
        }
        $params = [
            'fields' => 'items(id,snippet(channelId,title,categoryId),statistics)',
            'part' => 'snippet,statistics',
            'id' => $videoID
        ];
        $url = $this->generateURL('videos', $params);
        $response = $this->request($url);
        if (empty($response['items'])) {
            throw new AppException('YouTube returned an unsupported data structure.');
        }
        $response = $response['items'][0];
        foreach (['snippet', 'statistics'] as $item) {
            if (empty($response[$item])) {
                throw new AppException('YouTube returned an unsupported data structure.');
            }
        }

        return new VideoDTO(
            $videoID,
            $response['snippet']['title'],
            intval($response['statistics']['viewCount']),
            intval($response['statistics']['likeCount']),
            intval($response['statistics']['dislikeCount']),
            intval($response['statistics']['commentCount']),
        );
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
     * @throws AppException
     */
    private function request(string $url): array
    {
        $response = $this->sendRequest($url);
        $this->validateRequest($response);
        return $this->getResponse($response);
    }

    /**
     * @param string $url
     *
     * @return string
     * @throws AppException
     */
    private function sendRequest(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if (empty($response)) {
            throw new AppException('Request: ' . $url . ' return failed.');
        }
        curl_close($ch);
        return $response;
    }

    /**
     * @param string $response
     *
     * @throws AppException
     */
    private function validateRequest(string $response)
    {
        if (empty($response)) {
            throw new AppException('YouTube is not available.');
        }
        $response = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AppException('Error: ' . json_last_error());
        }
        if (empty($response)) {
            throw new AppException('YouTube returned data not in format is not JSON.');
        }
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function getResponse(string $response): array
    {
        return json_decode($response, true);
    }
}
