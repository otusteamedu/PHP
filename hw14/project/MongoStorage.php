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
    
    private $collection;
    
    public function __construct()
    {
        $this->client = new Client('mongodb://mongodb');
        $this->db = 'youtube';
        $this->collection = 'channels';
    }
    
    public function addChannel(array $channel){
        return $this->client->selectCollection($this->db, $this->collection)->insertOne($channel);
    }
    
    public function deleteChannel(string $channelName){
        return $this->client->selectCollection($this->db, $this->collection)->deleteOne(["channelName" => $channelName]);
    }
    
    public function getClient(){
        return $this->client;
    }

}