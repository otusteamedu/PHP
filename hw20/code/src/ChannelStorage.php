<?php
declare(strict_types=1);

/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

use MongoDB\Client;

class ChannelStorage
{
    public const MONGO_COLLECTION_NAME = 'YouTubeChannelCollection';
    public const MONGO_DB_NAME = 'YouTube';

    private $client;
    private $collection;

    public function __construct(string $uri = 'mongodb://mongodb')
    {
        $this->client = new Client($uri);
        $this->collection = $this->client->selectCollection(self::MONGO_DB_NAME, self::MONGO_COLLECTION_NAME);
    }

    public function addChannel(array $channel)
    {
        return $this->collection->insertOne($channel);
    }

    public function getChannelByName(string $name)
    {
        return $this->collection->findOne(["channelName" => $name]);
    }

    public function getAllChannelsData()
    {
        return $this->collection->find();
    }
}
