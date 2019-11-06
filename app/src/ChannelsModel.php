<?php

namespace App;

use MongoDB\Client;

class ChannelsModel
{
    private $name;
    private $description;
    private $videos;

    public const DB_NAME = 'YouTube';
    public const COLLECTION_NAME = 'ChannelsCollection';

    private $mongoClient;
    private $mongoCollection;

    public function __construct()
    {
        $this->mongoClient = new Client('mongodb://mongodb');
        $this->mongoCollection = $this->mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
    }

    /**
     * @param mixed $name
     * @return ChannelsModel
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     * @return ChannelsModel
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param array $videos
     * @return ChannelsModel
     */
    public function setVideos(array $videos)
    {
        $this->videos = $videos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function save()
    {
        $result =  $this->mongoCollection->insertOne([
            'name' => $this->name,
            'description' => $this->description,
            'videos' => $this->videos
        ]);
        return $result->getInsertedId();
    }

    /**
     * @param string $name
     * @return array|object|null
     */
    public function getChannelByName(string $name)
    {
        return $this->mongoCollection->findOne(["name" => $name]);
    }

    /**
     * @return array
     */
    public function getAllData()
    {
       return $this->mongoCollection->find()->toArray();

    }

    /**
     * @param string $channelName
     * @return int|mixed
     */
    public function getLikesStatisticsByChannelName(string $channelName)
    {
        $channel = $this->getChannelByName($channelName);
        $likes = 0;
        foreach ($channel['videos'] as $video) {
            $likes += $video['likes'];
        }
        return $likes;
    }
    public function getDislikesStatisticsByChannelName(string $channelName)
    {
        $channel = $this->getChannelByName($channelName);
        $dislikes = 0;
        foreach ($channel['videos'] as $film) {
            $dislikes += $film['dislikes'];
        }
        return $dislikes;
    }
    public function getTopChannelsStatistics(int $count): array
    {
        $topChannels = [];
        foreach ($this->getAllData() as $channel) {
            $channelName = $channel['name'];
            $topChannels[$channelName] = $this->getLikesStatisticsByChannelName($channelName) / $this->getDislikesStatisticsByChannelName($channelName);
        }
        arsort($topChannels);
        return array_slice($topChannels, 0, $count);
    }
}