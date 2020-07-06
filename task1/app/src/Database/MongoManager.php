<?php


namespace App\Database;


use App\Database\Drivers\MongoDb as Driver;
use MongoDB;

abstract class MongoManager
{
    const DB_NAME = 'youtube';
    /* @var MongoDB\Client */
    private $conn;
    /* @var \MongoDB\Collection */
    protected $collection = null;
    protected $collectionName = null;

    public function __construct()
    {
        $this->conn = Connection::getWrappedConnection(new Driver());
        $this->collection = $this->conn->selectDatabase(self::DB_NAME)->selectCollection($this->collectionName);
    }
}