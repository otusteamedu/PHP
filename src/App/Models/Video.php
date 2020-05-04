<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\VideoMapper;

Class Video
{
    // Кол-во возвращаемых видео от YoutubeApi, макс - 50
    const  MAX_RESULTS = 50;

    /**
     * Добавить новые видео для канала
     * @param $id_channel
     * @return array
     * @throws \Exception
     */
    public function scan($id_channel)
    {
        $nextPageToken = "";
        do {
            $videos = Youtube::getVideosForChannel($id_channel, [
                'maxResults' => 50,
                'pageToken' => $nextPageToken,
            ]);
            if (!$videos)
                return ['status' => 0, 'message' => 'videos not found'];

            if (empty($videos->items))
                break;

            foreach ($videos->items as $video) {
                // Избавимся от дублей
                if ((new VideoMapper(App::$db))->findOne(['id' => $video->id->videoId]))
                    continue;

                $video = [
                    'id' => $video->id->videoId,
                    'channelId' => $video->snippet->channelId,
                    'title' => $video->snippet->title,
                ];
                (new VideoMapper(App::$db))->insert($video);
            }

            $nextPageToken = isset($videos->nextPageToken) ? $videos->nextPageToken : "";
        } while(isset($videos->nextPageToken));

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Обновить рейтинг для видео
     * @param $id_channel
     * @return array
     * @throws \Exception
     */
    public function scanRating($id_channel)
    {
        $videos = (new VideoMapper(App::$db))->findAll(['$or' => [
            ['dateCheck' => ['$lt' => strtotime(date("Y-m-d 00:00:00"))]],
            ['dateCheck' => 0],
        ]]);
        if (!$videos)
            return ['status' => 0, 'message' => 'videos not found'];

        foreach ($videos as $video) {
            $videoRating = Youtube::getVideo($video->getId(), [
                'maxResults' => self::MAX_RESULTS,
                'part' => 'statistics',
            ]);

            if (!$videos && isset($videoRating->items[0]))
                return ['status' => 0, 'message' => 'videos not found'];

            $video->setLikes($videoRating->items[0]->statistics->likeCount)
                ->setDislikes($videoRating->items[0]->statistics->dislikeCount)
                ->setDateCheck(time());
            (new VideoMapper(App::$db))->update($video);
        }

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Суммарное кол-во лайков и дизлайков для канала по всем его видео
     * @return array
     */
    public function channelWithRating()
    {
        $channels = (new VideoMapper(App::$db))->aggregate([
            ['$group' => ['_id' => '$channelId', 'sumLikes' => ['$sum' => '$likes'], 'sumDislikes' => ['$sum' => '$dislikes']]],
            ['$lookup' => ['from' => 'Channel', 'localField' => '_id', 'foreignField' => 'id', 'as' => 'channelName']],
            ['$unwind' => '$channelName'],
        ]);

        $channelsNew = [];
        foreach ($channels as $channel) {
            $channelsNew[] = [
                'id' => $channel->channelName->id,
                'channel' => $channel->channelName->title,
                'likes' => $channel->sumLikes,
                'dislikes' => $channel->sumDislikes,
            ];
        }

        return ['status' => 1, 'message' => 'Done!', 'data' => $channelsNew];
    }

    /**
     * Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
     * @param int $count
     * @return array
     */
    public function topVideoRating(int $count)
    {
        $channels = (new VideoMapper(App::$db))->aggregate([
            ['$group' => ['_id' => '$channelId', 'sumLikes' => ['$sum' => '$likes'], 'sumDislikes' => ['$sum' => '$dislikes']]],
            ['$project' => ['_id' => 1, 'sumLikes' => 1, 'sumDislikes' => 1, 'ration' => ['$divide' => ['$sumLikes', '$sumDislikes']]]],
            ['$lookup' => ['from' => 'Channel', 'localField' => '_id', 'foreignField' => 'id', 'as' => 'channelName']],
            ['$unwind' => '$channelName'],
            ['$sort' => ['ration' => -1]],
            ['$limit' => $count]
        ]);

        $channelsNew = [];
        foreach ($channels as $channel) {
            $channelsNew[] = [
                'id' => $channel->channelName->id,
                'channel' => $channel->channelName->title,
                'likes' => $channel->sumLikes,
                'dislikes' => $channel->sumDislikes,
                'ration' => $channel->ration,
            ];
        }

        return ['status' => 1, 'message' => 'Done!', 'data' => $channelsNew];
    }

    /**
     * Все видео
     * @return array
     */
    public function videos()
    {
        $videos = (new VideoMapper(App::$db))->findAll();
        if (!$videos)
            return ['status' => 0, 'message' => 'videos not found'];

        return ['status' => 1, 'message' => 'Done!', 'data' => $videos];
    }

    public function lazyLoad(string $id)
    {
        $video = (new VideoMapper(App::$db))->findOne(['id' => $id]);
        if (!$video)
            return ['status' => 0, 'message' => 'videos not found'];

        $video->getChannel();
        return ['status' => 1, 'message' => 'Done!', 'data' => $video];
    }
}