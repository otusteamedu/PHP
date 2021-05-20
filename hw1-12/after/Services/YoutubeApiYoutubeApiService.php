<?php

/**
 * Class YoutubeApiService
 */
class YoutubeApiYoutubeApiService implements YoutubeApiServiceInterface
{
    private const MAX_RESULTS = 5;
    private const HTTP_CODE_OK = 200;

    /**
     * @var Client $client
     */
    private Client $client;

    /**
     * @var string $apiKey
     */
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['YOUTUBE_API_KEY'];
        $this->client = new Client();
    }

    /**
     * @param $channelId
     *
     * @return ChannelDTO
     * @throws InvalidResponseException
     * @throws YoutubeApiException
     * @throws YoutubeApiServerException
     */
    public function getChannelsInfo($channelId): ChannelDTO
    {
        $options = [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet,statistics',
                'id' => $channelId,
                'order' => 'date',
            ]
        ];
        try {
            $response = $this->client->request(
                'GET',
                'https://youtube.googleapis.com/youtube/v3/channels',
                $options);

            if ($response->getStatusCode() !== self::HTTP_CODE_OK) {
                throw new InvalidResponseException('Invalid StatusCode: ' . $response->getStatusCode());
            }
        } catch (GuzzleException $exception) {
            if (($exception->getCode() >= 500) && ($exception->getCode() < 600)) {
                $message = 'Server Error.';
                if ($exception instanceof ServerException) {
                    $message .= 'Response: ' . $exception->getResponse()->getBody()->getContents();
                }
                throw new YoutubeApiServerException($message);
            }
            throw new YoutubeApiException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $content = $response->getBody()->getContents();
        $channelInfo = json_decode($content, true);
        $channelDataParser = new ChannelDataParser();
        return $channelDataParser->parse($channelInfo);
    }

    /**
     * @param string $channelId
     *
     * @return array
     * @throws InvalidResponseException
     * @throws YoutubeApiException
     * @throws YoutubeApiServerException
     */
    public function getChannelVideos(string $channelId): array
    {
        $result = [];

        $videosIdList = $this->getVideosIdList($channelId);

        foreach ($videosIdList as $videoId) {
            $options = [
                'query' => [
                    'key' => $this->apiKey,
                    'part' => 'snippet,statistics',
                    'id' => $videoId,
                    'fields' => 'items(id,snippet(channelId,title,categoryId),statistics)',
                ]
            ];

            try {
                $response = $this->client->request(
                    'GET',
                    'https://youtube.googleapis.com/youtube/v3/videos',
                    $options);

                if ($response->getStatusCode() !== self::HTTP_CODE_OK) {
                    throw new InvalidResponseException('Invalid StatusCode: ' . $response->getStatusCode());
                }

                $content = $response->getBody()->getContents();
                $videoInfo = json_decode($content, true);
                $videoDataParser = new VideoDataParser();
                $videoDTO = $videoDataParser->parseVideoData($videoInfo);

                if ($videoDTO instanceof VideoDTO) {
                    $result[] = $videoDTO;
                }
            } catch (GuzzleException $exception) {
                if (($exception->getCode() >= 500) && ($exception->getCode() < 600)) {
                    $message = 'Server Error.';
                    if ($exception instanceof ServerException) {
                        $message .= 'Response: ' . $exception->getResponse()->getBody()->getContents();
                    }
                    throw new YoutubeApiServerException($message);
                }
                throw new YoutubeApiException($exception->getMessage(), $exception->getCode(), $exception);
            }
        }

        return $result;
    }

    /**
     * @param string $channelId
     *
     * @return array
     * @throws InvalidResponseException
     * @throws YoutubeApiException
     * @throws YoutubeApiServerException
     */
    private function getVideosIdList(string $channelId): array
    {
        $options = [
            'query' => [
                'part' => 'snippet',
                'order' => 'date',
                'channelId' => $channelId,
                'key' => $this->apiKey,
                'maxResults' => self::MAX_RESULTS,
            ]
        ];

        try {
            $response = $this->client->request(
                'GET',
                'https://youtube.googleapis.com/youtube/v3/search',
                $options);

            if ($response->getStatusCode() !== self::HTTP_CODE_OK) {
                throw new InvalidResponseException('Invalid StatusCode: ' . $response->getStatusCode());
            }

            $content = $response->getBody()->getContents();
            $videoIdsInfo = json_decode($content, true);
        } catch (GuzzleException $exception) {
            if (($exception->getCode() >= 500) && ($exception->getCode() < 600)) {
                $message = 'Server Error.';
                if ($exception instanceof ServerException) {
                    $message .= 'Response: ' . $exception->getResponse()->getBody()->getContents();
                }
                throw new YoutubeApiServerException($message);
            }
            throw new YoutubeApiException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $parser = new VideoDataParser();

        return $parser->parseVideosIdList($videoIdsInfo);
    }
}