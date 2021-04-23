<?php

namespace VideoPlatform\services;

use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use VideoPlatform\DB\ElasticSearch;
use VideoPlatform\exceptions\AppException;
use VideoPlatform\helpers\ArrayHelper;
use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\interfaces\VideoSharingServiceInterface;
use VideoPlatform\loggers\AppLogger;
use VideoPlatform\models\youtube\Channel;
use VideoPlatform\models\youtube\Video;
use VideoPlatform\statistics\YoutubeChannelStatistics;
use VideoPlatform\traits\RequestTrait;

class YoutubeService implements VideoSharingServiceInterface
{
    use RequestTrait;

    private string $apiKey;
    private string $youtubeApiUrl = 'https://youtube.googleapis.com/youtube/v3';

    private DBInterface $db;

	/**
	 * @throws \Exception
	 */
	public function __construct()
    {
        $config = $this->getConfig();

        $this->apiKey = $config['api_key'];
        $this->identifyDb();
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'api_key' => $_ENV['YOUTUBE_API_KEY'],
        ];
    }

    /**
     * @return array
     * @throws AppException|\GuzzleHttp\Exception\GuzzleException
     */
    public function getChannelDetail(): array
    {
        $url = $this->youtubeApiUrl . '/channels?part=snippet,contentDetails,statistics' . '&key=' . $this->apiKey;

        $data = $this->sendRequest('GET', $url . '&id=' . trim($_SERVER['argv'][2]));

	    if (empty($data['items'])) {
		    throw new AppException("Канал не найден \n");
	    }

        return $data['items'];
    }

    /**
     * @param $channelId
     * @param string $nextPageToken
     * @return array
     * @throws GuzzleException
     */
    public function getVideos($channelId, $nextPageToken = ''): array
    {
        $url = $this->youtubeApiUrl . '/search?channelId=' . $channelId . '&part=snippet&order=date&maxResults=5' .
            '&key=' . $this->apiKey;

        if (!empty($nextPageToken)) $url .= '&pageToken=' . $nextPageToken;

        return $this->sendRequest('GET', $url);
    }

    /**
     * @param $videoIds
     * @return array
     * @throws GuzzleException|AppException
     */
    public function getVideoDetail($videoIds): array
    {
        $videoIds = implode(',' , $videoIds);

        $url = $this->youtubeApiUrl . '/videos?part=snippet,statistics&id=' . $videoIds . '&key=' . $this->apiKey;

        $data = $this->sendRequest('GET', $url);

        if (empty($data['items'])) {
            throw new AppException("Видео не найдено \n");
        }

        return $data['items'];
    }

    /**
     * @throws GuzzleException
     * @throws AppException
     */
    public function analyze()
    {
        $channelDetails = $this->getChannelDetail();

        foreach ($channelDetails as $channel) {
            $this->saveChannelDetails($channel);

            $videos = $this->getVideos($channel['id']);
            $ids = $this->getVideoIds($videos);

            if (empty($ids)) {
                AppLogger::addLog(Logger::NOTICE, "There is no any video on channel: " . $channel['id']);
                continue;
            }

            $videosDetails = $this->getVideoDetail($ids);
            $this->saveChannelVideos($videosDetails);

            while (!empty($videos['nextPageToken'])) {
                $videos = $this->getVideos($channel['id'], $videos['nextPageToken']);
                $ids = $this->getVideoIds($videos);

                if (empty($ids)) {
                    AppLogger::addLog(Logger::NOTICE, "There is no any video on channel: " . $channel['id']);
                    continue 2;
                }

                $videosDetails = $this->getVideoDetail($ids);
                $this->saveChannelVideos($videosDetails);
            }
        }
    }

    /**
     * @param $details
     */
    public function saveChannelDetails($details)
    {
        $channel = new Channel();
        $channel->setId($details['id']);
        $channel->setTitle($details['snippet']['title']);
        $channel->setDescription($details['snippet']['description']);
        $channel->setViewCount($details['statistics']['viewCount']);
        $channel->setSubscriberCount($details['statistics']['subscriberCount']);
        $channel->setVideoCount($details['statistics']['videoCount']);

        $result = $channel->save($this->db);
        echo "Channel ID: $result \n";
    }

    public function saveChannelVideos($videoDetails)
    {
        foreach ($videoDetails as $videoDetail) {
            $video = new Video();

            $video->setId($videoDetail['id']);
            $video->setPublishedAt($videoDetail['snippet']['publishedAt']);
            $video->setChannelId($videoDetail['snippet']['channelId']);
            $video->setTitle($videoDetail['snippet']['title']);
            $video->setDescription($videoDetail['snippet']['description']);
            $video->setCategoryId($videoDetail['snippet']['categoryId']);
            $video->setViewCount($videoDetail['viewCount']);
            $video->setLikeCount($videoDetail['statistics']['likeCount']);
            $video->setDislikeCount($videoDetail['statistics']['dislikeCount']);
            $video->setCommentCount($videoDetail['statistics']['commentCount']);

            $result = $video->save($this->db);
            echo "Video ID: $result \n";
        }
    }

    /**
     * @param $id
     * @return Channel
     */
    public function findChannelById($id)
    {
        return Channel::findById($this->db, $id);
    }

    /**
     * @throws \Exception
     */
    private function identifyDb(): void
    {
        switch ($_ENV['NO_SQL_DB']) {
            case DBInterface::ELASTIC_SEARCH;
                $this->db = new ElasticSearch();
                break;
            default:
                throw new \Exception('wrong db');
        }
    }

    /**
     * @param $videos
     * @return array
     */
    private function getVideoIds($videos): array
    {
        $ids = ArrayHelper::getColumn($videos['items'], 'id');
        return ArrayHelper::getColumn($ids, 'videoId');
    }

    /**
     * @return array
     */
    public function getStatistics(): array
    {
        $channelIds = explode(',', $_SERVER['argv'][2]);

        foreach ($channelIds as $channelId) {
            $channel = Channel::findById($this->db, $channelId);
            $youtubeStatistics = new YoutubeChannelStatistics($this->db);
            $statistics = $youtubeStatistics->getTotalLikesDislikes($channel->getId());

            return [
                'channelId'=> $channelId,
                'LikeDislikeCounter' => $statistics
            ];
        }

        return [];
    }

    /**
     * @throws \Exception
     */
    public function getTopChannels(): array
    {
        $n = (int)$_SERVER['argv'][2];

        if (!is_int($n) or $n < 1) {
            throw new AppException("Аргумент должен быть int");
        }


        $topN = new YoutubeChannelStatistics($this->db);
        return $topN->getTopChannels($n);
    }
}
