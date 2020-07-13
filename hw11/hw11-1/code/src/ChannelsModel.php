<?php

namespace YoutubeApp;

use MongoDB\Client;

class ChannelsModel
{
    protected string $name;
    protected string $description;
    protected array  $videos;

    public const CONNECTION_STRING  = 'mongodb://localhost:27017';
    public const DB_NAME            = 'YouTubeChannels';
    public const COLLECTION_NAME    = 'ChannelsCollection';

    protected \MongoDB\Client $mongoClient;
    protected \MongoDB\Collection $mongoCollection;

    public function __construct()
    {
        $this->mongoClient = new \MongoDB\Client(self::CONNECTION_STRING);
        $this->mongoCollection = $this->mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
    }


    public function getChannelByName(string $name): object
    {
        return $this->mongoCollection->findOne(["name" => $name]);
    }

    public function getAllData(): array
    {
       return $this->mongoCollection->find()->toArray();

    }


}