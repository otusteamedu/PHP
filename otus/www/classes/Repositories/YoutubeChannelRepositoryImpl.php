<?php

namespace Classes\Repositories;


use Classes\Database\Databases;
use Classes\Models\YoutubeChannel;
use MongoDB\Client;

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

}
