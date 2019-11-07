<?php

namespace App;


use App\Database;

class ModelChannel extends Database
{

    public $API_key = 'API_key';
    public $channelID = 'channel_id';
    public $maxResults = 10;
    public $videoid = [];


    public function getVideoIds($channelDefaultId)
    {
        $videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $channelDefaultId . '&key=' . $this->API_key . ''));
        foreach ($videoList->items as $item) {
            if (isset($item->id->videoId)) {
                $this->videoid[] = $item->id->videoId;
            }
        }
    }
    private function saveVideo($videoDefaultId)
    {
        $video = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $videoDefaultId . '&key=' . $this->API_key . '&part=snippet,contentDetails,statistics,status'));
        $collectionYoutubeVideo = $this->db->youtube->video;
        $insertOneResult1 = $collectionYoutubeVideo->insertOne([
            'id' => $video->items[0]->id,
            'channelId' => $video->items[0]->snippet->channelId,
            'description' => $video->items[0]->snippet->description,
            'publishedAt' => $video->items[0]->snippet->publishedAt,
            'title' => $video->items[0]->snippet->title,
            'categoryId' => $video->items[0]->snippet->categoryId,
            'privacyStatus' => $video->items[0]->status->privacyStatus,
            'publicStatsViewable' => $video->items[0]->status->publicStatsViewable,
            'viewCount' => $video->items[0]->statistics->viewCount,
            'likeCount' => $video->items[0]->statistics->likeCount,
            'dislikeCount' => $video->items[0]->statistics->dislikeCount,
            'favoriteCount' => $video->items[0]->statistics->favoriteCount,
            'commentCount' => $video->items[0]->statistics->commentCount,
        ]);
        printf("Inserted %d video(s)\n", $insertOneResult1->getInsertedCount());
    }

    public function saveChannel($channelDefaultId)
    {
        $this->getVideoIds($channelDefaultId);
        $channel = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/channels?id=' . $channelDefaultId . '&key=' . $this->API_key . '&part=snippet,contentDetails,statistics,status'));
        $collectionYoutubeChannel = $this->db->youtube->channel;

        $insertOneResult2 = $collectionYoutubeChannel->insertOne([
            'id' => $channel->items[0]->id,
            "title" => $channel->items[0]->snippet->title,
            "description" => $channel->items[0]->snippet->description,
            'publishedAt' => $channel->items[0]->snippet->publishedAt,
            'viewCount' => $channel->items[0]->statistics->viewCount,
            'commentCount' => $channel->items[0]->statistics->commentCount,
            'subscriberCount' => $channel->items[0]->statistics->subscriberCount,
            'hiddenSubscriberCount' => $channel->items[0]->statistics->hiddenSubscriberCount,
            'videoCount' => $channel->items[0]->statistics->videoCount,
            'privacyStatus' => $channel->items[0]->status->privacyStatus,
            'videoId' => $this->videoid,
        ]);
        printf("Inserted %d channel(s)\n", $insertOneResult2->getInsertedCount());
        foreach ($this->videoid as $id) {
            $this->saveVideo($id);
        }
    }

    private function deletVideo($video)
    {
        $collectionYoutubeVideo = $this->db->youtube->video;
        $delet = $collectionYoutubeVideo->deleteOne(['id' => $video]);
    }
    public function deletChannel($channel)
    {
        $collectionYoutubeChannel = $this->db->youtube->channel;
        $find = $collectionYoutubeChannel->findOne(['id' => $channel]);
        foreach ($find['videoId'] as $item) {
            $this->deletVideo($item);
        }
        $delet = $collectionYoutubeChannel->deleteOne(['id' => $channel]);
    }
}
