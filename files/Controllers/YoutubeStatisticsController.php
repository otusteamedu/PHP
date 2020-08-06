<?php


namespace Controllers;

use Controllers\Contracts\YoutubeStatisticsInterface;
use MongoDB\Client;

class YoutubeStatisticsController implements YoutubeStatisticsInterface
{
    private $mongo = null;
    private $collection;

    public function __construct(Client $mongo)
    {
        $this->mongo = $mongo;
        $this->collection = $this->mongo->youtube->videos;
    }


    /**
     * Функция получения суммарного количества лайков всех видео канала YouTube
     * @param string $channelID Идентификатор канала
     * @return int
     */
    public function getChannelLikes(string $channelID): int
    {
        $result = $this->collection->find(
            ['_id' => $channelID],
            [
                'projection' => [
                    'videos.likeCount' => 1
                ]
            ]
        )->toArray();

        $likeAmount = 0;

        foreach ($result as $item) {
            $video = $item['videos'];
            foreach ($video as $like) {
                $likeAmount += $like['likeCount'];
            }
        }

        return $likeAmount;
    }

    /**
     * Функция получения суммарного количества дизЛайков всех видео канала YouTube
     * @param string $channelID Идентификатор канала
     * @return int
     */
    public function getChannelDislikes(string $channelID): int
    {
        $result = $this->collection->find(
            ['_id' => $channelID],
            [
                'projection' => [
                    'videos.dislikeCount' => 1
                ]
            ]
        )->toArray();

        $dislikeAmount = 0;

        foreach ($result as $item) {
            $video = $item['videos'];
            foreach ($video as $like) {
                $dislikeAmount += $like['dislikeCount'];
            }
        }

        return $dislikeAmount;
    }

    /**
     * Функция получения суммарной разницы лайков и дизЛайков канала YouTube
     * @param string $channelID  Идентификатор канала
     * @return int
     */
    public function getChannelLikeDifference(string $channelID): int
    {
        return self::getChannelLikes($channelID) - self::getChannelDislikes($channelID);
    }

    /**
     * Функция получения самых популярных видео Youtube
     * @param int $channelsAmount Количество каналов в рейтинге
     * @return array
     */
    public function getMostRatingChannels(int $channelsAmount = 5): array
    {

        $result = $this->collection->find(
            [],
            [
                'projection' => [
                    '_id' => 1
                ]
            ]
        )->toArray();

        $likesArray = [];

        foreach ($result as $item) {
            $likesArray[$item['_id']] =  self::getChannelLikeDifference($item['_id']);
        }

        arsort($likesArray);
        array_splice($likesArray, $channelsAmount);

        return $likesArray;
    }
}