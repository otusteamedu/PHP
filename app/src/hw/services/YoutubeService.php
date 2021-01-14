<?php

namespace VideoPlatform\services;

use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\DB\ElasticSearch;
use VideoPlatform\DB\MongoDB;
use VideoPlatform\models\youtube\Channel;

class YoutubeService
{
    private DBInterface $db;

    public function __construct()
    {
        $this->identifyDb();
    }

    public function saveChannelVideos()
    {

//        $client = ClientBuilder::create()->build();
//        $client->index();

    }

    public function saveChannelDetails($details)
    {
        $channel = new Channel();
        $channel->setId($details['id']);
        $channel->setTitle($details['snippet']['title']);
        $channel->setDescription($details['snippet']['description']);
        $channel->setViewCount($details['statistics']['viewCount']);
        $channel->setSubscriberCount($details['statistics']['subscriberCount']);
        $channel->setVideoCount($details['statistics']['videoCount']);

        $channel->save($this->db);
    }

    public function getChannelById($id)
    {
        return Channel::findById($this->db, $id);
    }

    /**
     * @throws \Exception
     */
    private function identifyDb(): void
    {
        switch ($_ENV['NO_SQL_DB']) {
            case DBInterface::ELASTIC_SEARCH;
                $this->db = new ElasticSearch();
                break;
            case DBInterface::MONGO_DB:
                $this->db = new MongoDB();
                break;
            default:
                throw new \Exception('wrong db');
        }
    }
}