<?php

namespace Services;

use Classes\Repositories\YoutubeChannelRepositoryInterface;
use Classes\Repositories\YoutubeVideoRepositoryInterface;
use MongoDB\Model\BSONDocument;

class ChannelStatisticServiceImpl implements ChannelStatisticServiceInterface
{

    private $youtubeChannelRepository;
    private $youtubeVideosRepository;

    public function __construct
    (
        YoutubeChannelRepositoryInterface $youtubeChannelRepository,
        YoutubeVideoRepositoryInterface $youtubeVideosRepository
    )
    {
        $this->youtubeChannelRepository = $youtubeChannelRepository;
        $this->youtubeVideosRepository = $youtubeVideosRepository;
    }

    public function getTotalChannelVideosLikesNumber(string $channelId, int $limit = null)
    {
        $channelVideosIds = $this->youtubeChannelRepository->getChannelVideosById($channelId);
        $videos = $this->getVideos($channelVideosIds);
        $sortedVideos = $this->sortByLikesDislakes($videos);

        if ($limit !== null) {
            $sortedVideos = array_slice($sortedVideos, 0, $limit, true);
        }

        $likesCnt = 0;
        $dislikesCnt = 0;
        foreach ($sortedVideos as $sortedVideo) {
            $likesCnt += $sortedVideo['likeCount'];
            $dislikesCnt += $sortedVideo['dislikeCount'];
        }

       return [
           'likes' => $likesCnt,
           'dislikes' => $dislikesCnt,
       ];
    }

    private function getVideos(array $channelVideos)
    {
       $videos =  $this->youtubeVideosRepository->getVideosByIds($channelVideos);

       if ($videos === null) {
           return null;
       }

       $result = [];
        /** @var BSONDocument $video */
       foreach ($videos as $video) {
           $item = $video->bsonSerialize();
           $result[] = json_decode(json_encode($item, JSON_THROW_ON_ERROR, 512), true, 512, JSON_THROW_ON_ERROR);
       }
      return $result;
    }

    private function sortByLikesDislakes (array $videos)
    {
        uasort($videos, static function ($first, $second) {
            $firstIndex = $first['likeCount'] / $first['dislikeCount'];
            $secondIndex = $second['likeCount'] / $second['dislikeCount'];
            if ($firstIndex === $secondIndex) {
                return 0;
            }
            return ($firstIndex < $secondIndex) ? 1 : -1;
        });

       return $videos;
    }

    public function getTopChannelsWithBestLikesDislikeRation(int $limit = null)
    {
        $result = [];
        $channels = $this->getChannels();

        /** @var BSONDocument $channel */
        foreach ($channels as $key => $channel) {
            $channelVideosIds = $this->youtubeChannelRepository->getChannelVideosById($channel->id);
            $videos = $this->getVideos($channelVideosIds);

            if ($videos === null) {
                continue;
            }

            $result[$key]['channel'] = json_decode(json_encode($channel->bsonSerialize(), JSON_THROW_ON_ERROR, 512), true, 512, JSON_THROW_ON_ERROR);
            $result[$key]['rating'] = $this->getVideoLikesRating($videos);
        }

        if (empty($result)) {
            return [];
        }

        $sortedChannels = $this->getSortedChannelsByRating($result);

        if ($limit === null) {
            return $sortedChannels;
        }
        return  array_slice($sortedChannels, 0, $limit, true);
    }

    private function getSortedChannelsByRating (array $channelsWithRating)
    {
        uasort($channelsWithRating, static function ($first, $second) {

            if ($first['rating'] === $second['rating']) {
                return 0;
            }
            return ($first['rating'] < $second['rating']) ? 1 : -1;
        });

        return $channelsWithRating;
    }

    private function getChannels ()
    {
        return $this->youtubeChannelRepository->getAll();
    }

    private function getVideoLikesRating(array $videos)
    {
        $likes = 0;
        $dislikes = 0;
        foreach ($videos as $video) {
            $likes += $video['likeCount'];
            $dislikes += $video['dislikeCount'];
        }
        return  $likes / $dislikes;
    }
}
