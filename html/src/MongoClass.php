<?php

namespace Ymdb;

class MongoClass
{
    protected $mongo;

    public function __construct()
    {
        $this->mongo = new \MongoDB\Client('mongodb://mongodb');
    }

    public function updateInfoChannel(array $info)
    {
        $collection = $this->mongo->test->channels;

        $updateResult = $collection->updateOne(
            ['_id' => $info["_id"]],
            ['$set' => $info],
            ['upsert' => true]
        );
    }

    public function updateInfoVideo(array $info)
    {
        $collection = $this->mongo->test->videos;

        $updateResult = $collection->updateOne(
            ['_id' => $info['_id']],
            ['$set' => $info],
            ['upsert' => true]
        );
    }

    public function removeVideo(string $videoId)
    {
        $collection = $this->mongo->test->videos;
        $deleteResult = $collection->deleteOne(['_id' => $videoId]);

        return $deleteResult->getDeletedCount();
    }

    public function removeChannel(string $channelId)
    {
        $collection = $this->mongo->test->channels;
        $deleteResult = $collection->deleteOne(['_id' => $videoId]);

        $collection = $this->mongo->test->videos;
        $deleteResult = $collection->deleteMany(['channelId' => $channelId]);

        return $deleteResult->getDeletedCount();
    }

}
