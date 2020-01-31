<?php

namespace Task;

use Core\AppException;
use Entity\YoutubeChannel;
use Entity\YoutubeVideo;
use Filter\YoutubeVideosFilter;
use stdClass;

class YoutubeCrawlerService
{
    private const YOUTUBE_API_URL = "https://www.googleapis.com/youtube/v3/";
    private const YOUTUBE_CHANNEL_HREF = "https://www.youtube.com/channel/";
    private const API_FUNC_CHANNEL_INFO = "channels";
    private const API_FUNC_CHANNEL_VIDEOS = "search";
    private const API_FUNC_VIDEOS_STATISTICS = "videos";
    
    private const REQ_CACHE_DIR = __DIR__ . "/cache/youtube/";

    /**
     * @var YoutubeCrawlerServiceConfig $config
     */
    private YoutubeCrawlerServiceConfig $config;

    /**
     * @var YoutubeChannel $channel
     */
    private YoutubeChannel $channel;

    /**
     * @var stdClass[] $videos
     */
    private array $videos = [];

    /**
     * @var stdClass[] $videoStatistics
     */
    private array $videoStatistics = [];

    /**
     * @var YoutubeVideo[] $videosCollection
     */
    private array $videosCollection = [];

    /**
     * @var string $channelId
     */
    private string $channelId = "";

    /**
     * YoutubeCrawlerService constructor.
     * @param YoutubeCrawlerServiceConfig $config
     * @param string                      $channelId
     */
    public function __construct(YoutubeCrawlerServiceConfig $config, string $channelId)
    {
        $this->channel = new YoutubeChannel();

        $this->config = $config;
        $this->channelId = $channelId;
    }

    /**
     * @throws AppException
     */
    public function run()
    {
        $this->parseChannelInfo();
        $this->setChannelVideos();
        $this->setVideosStatistics();
        $this->parseVideoCollection();
        $this->saveChannelData();
    }

    /**
     * @throws AppException
     */
    private function parseChannelInfo()
    {
        $res = $this->serviceQuery(self::API_FUNC_CHANNEL_INFO, [
            'id'   => $this->channelId,
            'part' => "snippet",
        ]);
        if ($res[0] instanceof stdClass) {
            $this->channel->setTitle($res[0]->snippet->title);
            $this->channel->setHashId($res[0]->id);
            $this->channel->setDescription($res[0]->snippet->description);
        } else {
            throw new AppException("channel {$this->channelId} parsing failed");
        }
    }

    private function setChannelVideos()
    {
        $res = $this->serviceQuery(self::API_FUNC_CHANNEL_VIDEOS, [
            'part'       => "snippet",
            'maxResults' => 50,
            'channelId'  => $this->channelId,
            'type'       => "video",
        ]);
        $this->videos = array_merge($this->videos, $res);
    }

    private function setVideosStatistics()
    {
        $res = $this->serviceQuery(self::API_FUNC_VIDEOS_STATISTICS, [
            'part' => "statistics",
            'id'   => implode(",", array_map(function (stdClass $video) {
                return $video->id->videoId;
            }, $this->videos)),
        ]);
        foreach ($res as $item) {
            $this->videoStatistics[$item->id] = $item->statistics;
        }
    }

    private function parseVideoCollection()
    {
        foreach ($this->videos as $videoRow) {
            $video = new YoutubeVideo();
            $video->setChannelId($this->channelId);
            $video->setHashId($videoRow->id->videoId);
            $video->setTitle($videoRow->snippet->title);
            $video->setDescription($videoRow->snippet->description);

            $statistics = $this->getStatisticsByVideoId($video->getHashId());
            $video->setLikesCount($statistics->likeCount ?? 0);
            $video->setDislikesCount($statistics->dislikeCount ?? 0);

            array_push($this->videosCollection, $video);
        }
    }

    /**
     * @param string $videoId
     * @return stdClass
     */
    private function getStatisticsByVideoId(string $videoId): stdClass
    {
        return $this->videoStatistics[$videoId] ?? new stdClass();
    }

    /**
     * @throws AppException
     */
    private function saveChannelData()
    {
        if (!empty($this->videosCollection)) {
            $this->channel->setLikesCount(array_sum(array_map(function (YoutubeVideo $video): int {
                return $video->getLikesCount();
            }, $this->videosCollection)));
            $this->channel->setDislikesCount(array_sum(array_map(function (YoutubeVideo $video): int {
                return $video->getDislikesCount();
            }, $this->videosCollection)));

            $this->channel->create();

            $vFilter = new YoutubeVideosFilter();
            $vFilter->setChannelId($this->channelId);
            YoutubeVideo::deleteCollection($vFilter);

            YoutubeVideo::createCollection($this->videosCollection);
        } else {
            throw new AppException("channel " . self::YOUTUBE_CHANNEL_HREF . "{$this->channelId} parsing failed, empty videos collection");
        }
    }

    /**
     * @param string $function
     * @param array  $params
     * @return stdClass[]
     */
    private function serviceQuery(string $function, array $params): array
    {
        $params["key"] = $this->config->getKey();
        $url = self::YOUTUBE_API_URL . "{$function}?" . http_build_query($params);
        $req = curl_init($url);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        $response = self::getResponseFromDisk($url) ?: curl_exec($req);
        $res = json_decode($response);
        if ($res && !($res->error ?? false) && is_array($res->items)) {
            $this->putResponseToDisk($url, $response);
            return $res->items;
        }
        return [];
    }

    /**
     * @param string $url
     * @param string $content
     */
    private static function putResponseToDisk(string $url, string $content)
    {
        $fPath = self::getCacheFilePath($url);
        file_put_contents($fPath, $content);
    }

    /**
     * @param string $url
     * @return string|null
     */
    private static function getResponseFromDisk(string $url): string
    {
        $fPath = self::getCacheFilePath($url);
        if (file_exists($fPath)) {
            return file_get_contents($fPath);
        }
        return "";
    }

    private static function getCacheFilePath(string $url): string
    {
        if (!file_exists(self::REQ_CACHE_DIR) && !is_dir(self::REQ_CACHE_DIR)) {
            mkdir(self::REQ_CACHE_DIR, 0644, true);
        }
        return self::REQ_CACHE_DIR . md5($url) . ".json";
    }

    /**
     * @return YoutubeChannel
     */
    public function getChannel(): YoutubeChannel
    {
        return $this->channel;
    }

    /**
     * @return YoutubeVideo[]
     */
    public function getVideosCollection(): array
    {
        return $this->videosCollection;
    }
}