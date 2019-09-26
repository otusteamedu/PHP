<?php
declare(strict_types=1);
use MongoDB\Client;

class MongoStorage
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string 
     */
    private $db;

    /**
     * @var \MongoDB\Collection 
     */
    private $collection;
    
    public function __construct(string $uri, string $db, string $collection)
    {
        $this->client = new Client($uri);
        $this->db = $db;
        $this->collection = $this->client->selectCollection($this->db, $collection);
    }
    
    public function addChannel(array $channel){
        return $this->collection->insertOne($channel);
    }
    
    public function deleteChannel(string $channelName){
        return $this->collection->deleteOne(["channelName" => $channelName]);
    }
    
    public function getChannels()
    {
        return $this->collection->find();
    }
    public function getChannelByName(string $name)
    {
        return $this->collection->findOne(["channelName" => $name]);
    }
    
    public function getClient(){
        return $this->client;
    }

}