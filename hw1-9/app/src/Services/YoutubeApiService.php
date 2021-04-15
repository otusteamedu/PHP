<?php

namespace Src\Services;

use GuzzleHttp\Client;
use Src\DTO\ChannelDTO;
use Src\DTO\VideoDTO;
use Src\Parsers\Youtube\ChannelDataParser;
use Src\Parsers\Youtube\VideoDataParser;

/**
 * Class YoutubeApiService
 */
class YoutubeApiService
{
    private const MAX_RESULTS = 10;
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
     * @throws \Exception
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

        $response = $this->client
            ->get('https://youtube.googleapis.com/youtube/v3/channels', $options)
            ->getBody()
            ->getContents();

        $channelInfo = json_decode($response, true);
        $channelDataParser = new ChannelDataParser();
        return $channelDataParser->parse($channelInfo);
    }

    /**
     * @param string $channelId
     *
     * @return array
     * @throws \Exception
     */
    public function getChannelVideos (string $channelId): array
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

            $response = $this->client
                ->get('https://youtube.googleapis.com/youtube/v3/videos', $options)
                ->getBody()
                ->getContents();

            $videoInfo = json_decode($response, true);
            $videoDataParser = new VideoDataParser();
            $videoDTO = $videoDataParser->parseVideoData($videoInfo);

            if ($videoDTO instanceof VideoDTO) {
                $result[] = $videoDTO;
            }
        }

        return $result;
    }

    /**
     * @param string $channelId
     *
     * @return array
     * @throws \Exception
     */
    private function getVideosIdList (string $channelId): array
    {
        $options = [
            'query' => [
                'part'       => 'snippet',
                'order'      => 'date',
                'channelId'  => $channelId,
                'key'        => $this->apiKey,
                'maxResults' => self::MAX_RESULTS,
            ]
        ];

        $response = $this->client
            ->get('https://youtube.googleapis.com/youtube/v3/search', $options)
            ->getBody()
            ->getContents();

        $videoIdsInfo = json_decode($response, true);
        $parser = new VideoDataParser();

        return $parser->parseVideosIdList($videoIdsInfo);
    }
}