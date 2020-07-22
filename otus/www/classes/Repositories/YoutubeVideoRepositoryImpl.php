<?php

namespace Classes\Repositories;

use Classes\Database\Databases;
use Classes\Models\YoutubeVideo;
use MongoDB\Client;

class YoutubeVideoRepositoryImpl implements YoutubeVideoRepositoryInterface
{
    private $collection;

    public function __construct(Client $dbConnection)
    {
        $this->collection = $dbConnection->selectDatabase(Databases::MONGO_DB_NAME)->selectCollection(Databases::VIDEOS_YOUTUBE_COLLECTION);
    }

    /**
     * @param YoutubeVideo $youtubeVideoModel
     * @return \MongoDB\InsertOneResult|\MongoDB\UpdateResult
     */
    public function create(YoutubeVideo $youtubeVideoModel)
    {
        $dbVideo = $this->getVideoById($youtubeVideoModel->id);

        if ($dbVideo) {
           return $this->collection->updateOne(
               ['id' => $youtubeVideoModel->id],
               ['$set' => $youtubeVideoModel]);
        }

        return $this->collection->insertOne($youtubeVideoModel);
    }

    public function getVideoById(string $id)
    {
        $dbVideo = $this->collection->findOne([
            'id' => $id
        ]);
        return $dbVideo ?? null;
    }

    /**
     * @param string $id
     */
    public function deleteById(string $id)
    {
        $this->collection->findOneAndDelete(['id' => $id]);
    }

    public function getVideosByIds(array $channelVideos)
    {
        $bsonDocuments = [];
        foreach ($channelVideos as $videoId) {
            $document = $this->getVideoById($videoId);
            if ($document === null) {
                continue;
            }
            $bsonDocuments[] = $this->getVideoById($videoId);
        }
        return !empty($bsonDocuments) ? $bsonDocuments : null;
    }
}
