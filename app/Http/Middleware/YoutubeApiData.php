<?php


namespace App\Http\Middleware;


class YoutubeApiData
{
    const SEARCH = 'search';
    const VIDEO = 'videos';
    const MAX_CHANNELS_GET = 50; //максимум ютуб ограничивает 50 каналами
    const MAX_VIDEOS_GET = 100;

    private string $url;
    private string $youtube_api_key;

    /**
     * YoutubeApiData constructor.
     * @param string $url
     * @param string $youtube_api_key
     */
    public function __construct()
    {
        $this->url = config('services.youtube.url');
        $this->youtube_api_key = config('services.youtube.apikey');
    }

    /**
     * Возвращает из Ютуба self::MAX_CHANNELS_GET каналов.
     * @return array
     */
    public function getRandomChannels():array
    {
        $method = self::SEARCH;
        $channels = [];
        try {
            $channels = json_decode(
                file_get_contents(
                    $this->url
                    . "$method?"
                    . 'part=id,snippet&type=channel&maxResults='.self::MAX_CHANNELS_GET
                    . "&key=" . $this->youtube_api_key
                ),
                true
            )['items'];
        } catch (\ErrorException $ex) {
            echo "Error: Failed to get random channels. ", $ex->getMessage() . PHP_EOL;
        }
        return $channels;
    }

    /**
     * Возвращает из Ютуба self::MAX_VIDEOS_GET видео для канала.
     * @param string $channel
     * @return array
     */
    public function getAllVideoFromChannel(string $channel): array
    {
        $videos = [];
        $method = self::SEARCH;
        try {
            $videos = json_decode(
                file_get_contents(
                    $this->url
                    . "$method?"
                    . "channelId=$channel&part=snippet,id&order=date&maxResults=" . self::MAX_VIDEOS_GET
                    . "&key=" . $this->youtube_api_key
                ),
                true
            )['items'];
        } catch (\ErrorException $ex) {
            echo "Error: Failed to get videos for channel $channel ". PHP_EOL
                . $ex->getMessage() . PHP_EOL ;
        }
        return $videos;
    }

    /**
     * Запрашивает данные по статистике для Видео
     * @param string $videoId
     * @return array
     */
    public function getVideoStatisticByVideoId(string $videoId): array
    {
        $method = self::VIDEO;
        $statistic = [];
        try {
            $statistic = json_decode(
                file_get_contents(
                    $this->url
                    . "$method?"
                    . "part=snippet,contentDetails,statistics&id=$videoId"
                    . "&key=" . $this->youtube_api_key
                ),
                true
            )['items'];
            $statistic = $statistic[0] ?? $statistic;
        } catch (\ErrorException $ex) {
            echo "Error: Failed to get statistic for video $videoId ". PHP_EOL;
        }
        return $statistic;
    }

}
