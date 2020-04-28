<?php

namespace Ozycast\App;

Class Video extends VideoModel
{
    // Кол-во возвращаемых видео от YoutubeApi, макс - 50
    const  MAX_RESULTS = 50;

    /**
     * Добавить новые видео для канала
     * @param $id_channel
     * @return array
     */
    public function scan($id_channel)
    {
        $nextPageTocken = "";
        do {
            $videos = Youtube::getVideosForChannel($id_channel, [
                'maxResults' => 50,
                'pageToken' => $nextPageTocken,
            ]);
            if (!$videos)
                return ['status' => 0, 'message' => 'videos not found'];

            if (empty($videos->items))
                break;

            foreach ($videos->items as $video) {
                // Избавимся от дублей
                if (VideoModel::find(['id' => $video->id->videoId]))
                    continue;

                $model = new VideoModel();
                $model->id = $video->id->videoId;
                $model->channelId = $video->snippet->channelId;
                $model->title = $video->snippet->title;
                if (!$model->save())
                    return ['status' => 0, 'message' => $model->getError()];
            }

            $nextPageTocken = isset($videos->nextPageToken) ? $videos->nextPageToken : "";
        } while(isset($videos->nextPageToken));

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Обновить рейтинг для видео
     * @param $id_channel
     * @return array
     */
    public function scanRating($id_channel)
    {
        $videos = $this->findAll(['$or' => [
            ['date_check' => ['$lt' => strtotime(date("Y-m-d 00:00:00"))]],
            ['date_check' => null],
        ]]);
        if (!$videos)
            return ['status' => 0, 'message' => 'videos not found'];

        foreach ($videos as $video) {
            $videoRating = Youtube::getVideo($video->id, [
                'maxResults' => self::MAX_RESULTS,
                'part' => 'statistics',
            ]);

            if (!$videos && isset($videoRating->items[0]))
                return ['status' => 0, 'message' => 'videos not found'];

            $video->likes = (int) $videoRating->items[0]->statistics->likeCount;
            $video->dislikes = (int) $videoRating->items[0]->statistics->dislikeCount;
            $video->date_check = (int) time();
            if (!$video->update())
                return ['status' => 0, 'message' => $video->getError()];
        }

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Суммарное кол-во лайков и дизлайков для канала по всем его видео
     * @return array
     */
    public function channelWithRating()
    {
        $channels = App::$db->aggregate($this->getCollectName(), [
            ['$group' => ['_id' => '$channelId', 'sumLikes' => ['$sum' => '$likes'], 'sumDislikes' => ['$sum' => '$dislikes']]],
            ['$lookup' => ['from' => ChannelModel::getCollectName(), 'localField' => '_id', 'foreignField' => 'id', 'as' => 'channelName']],
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
     * @return array
     */
    public function topVideoRating($count)
    {
        $channels = App::$db->aggregate($this->getCollectName(), [
            ['$group' => ['_id' => '$channelId', 'sumLikes' => ['$sum' => '$likes'], 'sumDislikes' => ['$sum' => '$dislikes']]],
            ['$project' => ['_id' => 1, 'sumLikes' => 1, 'sumDislikes' => 1, 'ration' => ['$divide' => ['$sumLikes', '$sumDislikes']]]],
            ['$lookup' => ['from' => ChannelModel::getCollectName(), 'localField' => '_id', 'foreignField' => 'id', 'as' => 'channelName']],
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
        $videos = (new VideoModel())->findAll();
        if (!$videos)
            return ['status' => 0, 'message' => 'videos not found'];

        return ['status' => 1, 'message' => 'Done!', 'data' => $videos];
    }
}