<?php
namespace Ozycast\App;

use MongoDB\Client;

Class DbMongo implements Db
{
    private $connection;
    private $db;

    public function connect()
    {
        if ($this->db)
            return $this->db;

        $login = $_ENV["MONGO_USER"].":".$_ENV["MONGO_PASSWORD"];
        $address = $_ENV["MONGO_HOST"].":".$_ENV["MONGO_PORT"];

        $this->connection = new Client("mongodb://".$login."@".$address);
        $this->db = $this->connection->selectDatabase($_ENV["MONGO_DB"]);
        return $this;
    }

    public function insert($collection, $data)
    {
        $this->db->selectCollection($collection)->insertOne($data);
    }

    public function update($collection, $filter, $data)
    {
        $this->db->selectCollection($collection)->updateOne($filter, [
            '$set' => $data,
        ]);
    }

    public function findAll($collection, $params)
    {
        return $this->db->selectCollection($collection)->find($params)->toArray();
    }

    public function findOne($collection, $params)
    {
        return $this->db->selectCollection($collection)->findOne($params);
    }

    public function aggregate($collection, $params)
    {
        return $this->db->selectCollection($collection)->aggregate($params)->toArray();
    }
}