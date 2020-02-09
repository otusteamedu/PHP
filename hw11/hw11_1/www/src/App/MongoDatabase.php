<?php
namespace App;

use MongoDB\Client;

class MongoDatabase
{
    public $mongoClient;
    /**
     * @var \MongoDB\Collection
     */
    protected $mongoCollection;
    public const DB_NAME = 'YouTube';

    public function __construct()
    {
        $this->mongoClient = new Client('mongodb://mongodb');
    }
}