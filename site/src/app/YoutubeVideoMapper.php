<?php
namespace App;
use App\YoutubeVideo;

class YoutubeVideoMapper
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insert($raw)
    {
        $collectionYoutubeVideo = $this->db->youtube->video;

        $insertOneResult = $collectionYoutubeVideo->insertOne([
            'id' => $raw['id'],
            'channelId' => $raw['channelId'],
            'description' => $raw['description'],
            'publishedAt' => $raw['publishedAt'],
            'title' => $raw['title'],
            'categoryId' => $raw['categoryId'],
            'privacyStatus' => $raw['rivacyStatus'],
            'publicStatsViewable' => $raw['publicStatsViewable'],
            'viewCount' => $raw['viewCount'],
            'likeCount' => $raw['likeCount'],
            'dislikeCount' => $raw['dislikeCount'],
            'favoriteCount' => $raw['favoriteCount'],
            'commentCount' => $raw['commentCount'],
        ]);

        return $insertOneResult;
    }

    public function getById($id)
    {

        $collectionYoutubeVideo = $this->db->youtube->video;
        $findOneResult = $collectionYoutubeVideo->findOne(['id' => $id]);
        return new YoutubeVideo(
            $findOneResult["_id"],
            $id,
            $findOneResult["channelId"],
            $findOneResult["description"],
            $findOneResult["publishedAt"],
            $findOneResult["title"],
            $findOneResult["categoryId"],
                $findOneResult['privacyStatus'],
            $findOneResult["publicStatsViewable"],
            $findOneResult['viewCount'],
            $findOneResult['likeCount'],
            $findOneResult['dislikeCount'],
            $findOneResult['favoriteCount'],
            $findOneResult['commentCount']
        );
    }

    public function delete($YoutubeVodeo)
    {

        $collectionYoutubeChannel = $this->db->youtube->channel;
        return $delete = $collectionYoutubeChannel->deleteOne(['id' => $YoutubeVodeo->get_Id()]);
    }
}
