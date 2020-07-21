<?php

namespace Classes\Repositories;

use Classes\Database\Databases;
use Classes\Database\DbConnection;
use Classes\Models\YoutubeVideo;
use MongoDB\Client;

class YoutubeVideoRepository implements YoutubeRepository
{
    /**
     * @var DbConnection
     */
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
               [ '$set' => $youtubeVideoModel]);
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

}
