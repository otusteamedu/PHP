<?php

namespace Classes\Repositories;

use Classes\Database\Databases;
use Classes\Models\YoutubeChannel;
use MongoDB\Client;
use MongoDB\Model\BSONDocument;

class YoutubeChannelRepositoryImpl implements YoutubeChannelRepositoryInterface
{

    private $collection;

    public function __construct(Client $dbConnection)
    {
        $this->collection = $dbConnection->selectDatabase(Databases::MONGO_DB_NAME)->selectCollection(Databases::CHANNELS_YOUTUBE_COLLECTION);
    }

    public function create(YoutubeChannel $model)
    {
        $dbChannel = $this->getChannelById($model->id);

        if ($dbChannel) {
            return $this->collection->updateOne(
                ['id' => $model->id],
                ['$set' => $model]);
        }

        return $this->collection->insertOne($model);
    }

    public function getChannelById(string $id)
    {
        $dbChannel = $this->collection->findOne([
            'id' => $id
        ]);
        return $dbChannel ?? null;
    }


    public function deleteById(string $id)
    {
        $this->collection->findOneAndDelete(['id' => $id]);
    }

    public function getById(string $id)
    {
        // TODO: Implement getById() method.
    }

    public function getChannelVideosById(string $channelId): array
    {
        /** @var BSONDocument $collection */
        $collection = $this->collection->findOne(['id' => $channelId]);

        if (!$collection) {
            return [];
        }
        $data = $collection->jsonSerialize();
        /** @var BSONDocument $videos */
        $videos = $data->videoIds;

        if (!$videos) {
            return [];
        }

        return json_decode(json_encode($videos->jsonSerialize(), JSON_THROW_ON_ERROR, 512), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getAll()
    {
        return $this->collection->find()->toArray();
    }
}
