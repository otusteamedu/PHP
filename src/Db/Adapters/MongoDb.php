<?php

namespace Bjlag\Db\Adapters;

use Bjlag\Db\Store;
use MongoDB\BSON\ObjectId;

class MongoDb implements Store
{
    /** @var \MongoDB\Client */
    private $client;

    /** @var string */
    private $dbname;

    /**
     * mongodb://[username:password@]host1[:port1][,host2[:port2],...[,hostN[:portN]]][/[database][?options]]
     *
     * @param string $uri
     * @param string $dbname
     * @return \Bjlag\Db\Adapters\MongoDb
     */
    public function getConnection(string $uri, string $dbname): Store
    {
        $this->client = new \MongoDB\Client($uri);
        $this->dbname = $dbname;

        return $this;
    }

    public function find(string $from, array $select = [], array $where = [], ?int $limit = null, ?int $offset = null): array
    {
        $options = [];
        $columns = [];
        foreach ($select as $column) {
            $columns[$column] = 1;
        }

        if (count($columns) > 0){
            $options['projection'] = $columns;
        }

        $result = [];
        $collection = $this->client->selectCollection($this->dbname, $from);
        $rows = $collection->find($where, $options)->toArray();

        foreach ($rows as $row) {
            $data = [];
            foreach ($row as $key => $field) {
                if ($field instanceof ObjectId) {
                    $field = $field->jsonSerialize();
                    $data['id'] = $field['$oid'];
                } else {
                    $data[$key] = $field;
                }
            }

            $result[] = $data;
        }

        return $result;
    }

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
